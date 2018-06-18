<template>
<div>
  <template v-if="completed">
    <h2 class="mb-5 text-center">{{ $t('thank_you') }}!</h2>
    <h3 class="mb-5 text-center">{{ $t('rental_success_message') }}.</h3>
  </template>
  <template v-else>
    <h2 class="mb-5 text-center">{{ $t('rental') }}</h2>
    <FormWizard
      :title="null"
      :subtitle="null"
      :next-button-text="$t('next_step')"
      :back-button-text="$t('previous_step')"
      :finish-button-text="$t('finish')"
      color="#007bff"
      error-color="#dc3545"
      shape="square"
      ref="wizard"
    >
      <TabContent :title="$t('choose_location')" :before-change="wizardBeforeChange">
        <div class="row">
          <div class="col-md-4 offset-md-4 text-center pt-2">
            <ul class="list-group">
              <li class="list-group-item text-center"
                v-for="(location, locationIndex) in locationsList"
                :key="locationIndex"
                :class="{
                  'active': filters.location === location.value
                }"
                @click.prevent="setFilter('location', location.value)"
              >{{ location.label }}</li>
            </ul>
          </div>
        </div>
      </TabContent>
      <TabContent :title="$t('choose_car')" :before-change="wizardBeforeChange">
        <div class="col-md-12 text-center">
          <div class="col-md-4 offset-md-4 text-center pt-2">
            <ul class="list-group">
              <li class="list-group-item text-center"
                v-for="(car, carIndex) in carsList"
                :key="carIndex"
                :class="{
                  'active': filters.car === car.value
                }"
                @click.prevent="setFilter('car', car.value)"
              >{{ car.label }}</li>
            </ul>
          </div>
        </div>        
      </TabContent>
      <TabContent :title="$t('choose_appointment')" :before-change="wizardBeforeChange">
        <div class="mb-5">
          <div class="row">
            <div class="col-md-12 mb-4 text-center">
              <h3>{{ $t('choose_appointment') }}</h3>
            </div>
            <div class="col-md-4">
              <datepicker
                v-model="filters.date"
                :inline="true"
                :monday-first="true"
                maximum-view="month"
                :full-month-name="true"
                :disabled="datepickerDisabledConfig"
                language="sr"
                :bootstrap-styling="true"
                class="rental-datepicker"
              ></datepicker>
            </div>
            <div class="col-md-8">
              <span
                class="appointment-slot"
                v-for="(appointment, appointmentIndex) in appointmentsList"
                :key="appointmentIndex"
                @click="appointment.disabled === false && setFilter('appointment', appointment.startTime.format('X'))"
                :class="{
                  'selected': filters.appointment == appointment.startTime.format('X'),
                  'disabled': appointment.disabled === true
                }"
                v-tooltip.top="appointment.disabled ? $t('appointment_is_not_available') : $t('appointment_is_available')"
              >{{ appointment.label }}</span>
            </div>
          </div>
        </div>        
      </TabContent>
      <TabContent :title="$t('enter_your_info')" :before-change="wizardBeforeChange">
        <template slot="icon">
          asdf
        </template>
        <form @submit.prevent class="personalInfo-form">
          <div class="form-group required row" :class="{ 'has-error': personalInfoErrors.indexOf('firstName') > -1 }">
            <label class="col-md-4 col-form-label">
              {{ $t('first_name') }}
            </label>
            <div class="col-md-8">
              <input type="text" v-model="personalInfo.firstName" class="form-control" />
            </div>
          </div>
          <div class="form-group required row" :class="{ 'has-error': personalInfoErrors.indexOf('lastName') > -1 }">
            <label class="col-md-4 col-form-label">
              {{ $t('last_name') }}
            </label>
            <div class="col-md-8">
              <input type="text" v-model="personalInfo.lastName" class="form-control" />
            </div>
          </div>
          <div class="form-group required row" :class="{ 'has-error': personalInfoErrors.indexOf('email') > -1 }">
            <label class="col-md-4 col-form-label">
              {{ $t('email') }}
            </label>
            <div class="col-md-8">
              <input type="email" v-model="personalInfo.email" class="form-control" />
            </div>
          </div>
          <div class="form-group required row" :class="{ 'has-error': personalInfoErrors.indexOf('licenseNumber') > -1 }">
            <label class="col-md-4 col-form-label">
              {{ $t('license_number') }}
            </label>
            <div class="col-md-8">
              <input type="text" v-model="personalInfo.licenseNumber" class="form-control" />
            </div>
          </div>
          <div class="form-group required row" :class="{ 'has-error': personalInfoErrors.indexOf('address') > -1 }">
            <label class="col-md-4 col-form-label">
              {{ $t('address') }}
            </label>
            <div class="col-md-8">
              <input type="text" v-model="personalInfo.address" class="form-control" />
            </div>
          </div>
          <div class="form-group required row" :class="{ 'has-error': personalInfoErrors.indexOf('city') > -1 }">
            <label class="col-md-4 col-form-label">
              {{ $t('city') }}
            </label>
            <div class="col-md-8">
              <input type="text" v-model="personalInfo.city" class="form-control" />
            </div>
          </div>
          <div class="form-group row" :class="{ 'has-error': personalInfoErrors.indexOf('zip') > -1 }">
            <label class="col-md-4 col-form-label">
              {{ $t('zip') }}
            </label>
            <div class="col-md-8">
              <input type="text" v-model="personalInfo.zip" class="form-control" />
            </div>
          </div>
          <div class="form-group row" :class="{ 'has-error': personalInfoErrors.indexOf('state') > -1 }">
            <label class="col-md-4 col-form-label">
              {{ $t('state') }}
            </label>
            <div class="col-md-8">
              <input type="text" v-model="personalInfo.state" class="form-control" />
            </div>
          </div>
          <div class="form-group required row" :class="{ 'has-error': personalInfoErrors.indexOf('country') > -1 }">
            <label class="col-md-4 col-form-label">
              {{ $t('country') }}
            </label>
            <div class="col-md-8">
              <input type="text" v-model="personalInfo.country" class="form-control" />
            </div>
          </div>
        </form>
      </TabContent>
      <button slot="next" type="button" class="btn btn-primary">{{ $t('next_step') }}</button>
      <button slot="previous" type="button" class="btn btn-primary">{{ $t('previous_step') }}</button>
      <button slot="finish" type="button" @click="submit" class="btn btn-success" :class="{ 'btn-loading': submitting }">{{ $t('confirm') }}</button>
    </FormWizard>
  </template>
</div>
</template>

<script>

import axios from 'axios'
import Vue from 'vue'
import { debounce } from 'lodash'
import Datepicker from 'vuejs-datepicker'
import moment from 'moment'
import swal from 'sweetalert2'
import { FormWizard, TabContent } from 'vue-form-wizard'

export default {

  components: {
    Datepicker,
    FormWizard,
    TabContent
  },

  metaInfo () {
    return { title: this.$t('rental') }
  },

  data(){
    return {
      completed: false,
      submitting: false,
      filters: {
        car: null,
        location: null,
        date: new Date(),
        appointment: 0
      },
      cars: [],
      locations: [],
      appointments: [],
      personalInfo: {
        email: '',
        firstName: '',
        lastName: '',
        licenseNumber: '',
        address: '',
        zip: '',
        city: '',
        state: '',
        country: ''
      },
      personalInfoErrors: []
    }
  },

  created(){
    this.fetchLocations()
    this.fetchCars()
    Vue.set(this.filters, 'date', this.getFirstAvailableDate())
  },

  methods: {
    async fetchLocations(){
      const { data } = await axios.get('/api/locations')
      Vue.set(this, 'locations', data)
    },
    async fetchCars(){
      const { data } = await axios.get('/api/cars')
      Vue.set(this, 'cars', data)
    },
    async fetchAppointments(){
      const { data } = await axios.get(`/api/appointments/${this.filters.location}/${this.filters.car}/${this.selectedDate}`)
      if(data && data.length){
        for(let appointment of data){
          this.appointments.push(appointment)
        }
      }
    },
    getFirstAvailableDate(){
      if (moment().isoWeekday() <= 1) {
        return moment().isoWeekday(1).toDate()
      } else {
        return moment().add(1, 'weeks').isoWeekday(1).toDate()
      }
    },
    setFilter(key, val){
      if(key === 'location'){
        Vue.set(this.filters, 'car', null)
        Vue.set(this.filters, 'date', this.getFirstAvailableDate())
        Vue.set(this.filters, 'appointment', null)
      }
      if(key === 'date'){
        Vue.set(this.filters, 'appointment', null)
      }
      Vue.set(this.filters, key, val)
    },
    filtersChanged: debounce( (filters, callback) => {
      if(filters.location && filters.car){
        callback()
      }
    }, 300 ),
    dateIsWorkday(date){
      return [6,7].indexOf(moment(date).isoWeekday()) === -1
    },
    datetimeIsTaken(datetime){
      for(let appointment of this.appointments){
        if(moment(appointment.datetime).isSame(moment(datetime))){
          return true
        }
      }
      return false
    },
    wizardBeforeChange(){
      const currentStep = this.$refs.wizard.activeTabIndex
      switch(currentStep){
        case 0:
          return !!this.selectedLocation
        break;
        case 1:
          return !!this.selectedCar
        break;
        case 2:
          return !!this.filters.date && !!this.filters.appointment 
        break;
        case 3:
          Vue.set(this, 'personalInfoErrors', [])
          return true
        break;
      }
      return false
    },
    async submit(){
      this.submitting = true
      const response = await axios.post(`/api/appointments/${this.filters.location}/${this.filters.car}/${this.selectedDatetime}`, {
        ...this.personalInfo,
      }).catch((thrown) => {
        if(!axios.isCancel(thrown)){
          swal(this.$t('error_alert_title'), this.$t('please_fill_the_required_fields'), 'error')
          for(let key in thrown.response.data.errors){
            this.personalInfoErrors.push(key)
          }
        }
      });
      this.submitting = false
      if(response && response.data && response.data.success === true){
        this.completed = true
      }
    }
  },

  computed: {
    locationsList(){
      return this.locations.map((location) => {
        return { value: location._id, label: location.city + ' - ' + location.address }
      }).sort((a, b) => {
        if(a.label < b.label) return -1
        if(a.label > b.label) return 1
        return 0
      })
    },
    selectedLocation(){
      for(var location of this.locations){
        if(location._id == this.filters.location){
          return location
        }
      }
      return null
    },
    carsList(){
      return this.cars.filter((car) => {
        if(!this.selectedLocation){
          return []
        }
        return this.selectedLocation.availableCars.indexOf(car._id) > -1
      }).map((car) => {
        return { value: car._id, label: car.model }
      })
    },
    selectedCar(){
      for(var car of this.cars){
        if(car._id == this.filters.car){
          return car
        }
      }
      return null
    },
    appointmentsList(){

      const opensAt = 7
      const workHours = 12
      const startTime = moment(this.filters.date).startOf('day').add(opensAt, 'hours')
      const endTime = moment(this.filters.date).startOf('day').add(opensAt + workHours, 'hours')
      const startEndMinuteDifference = Math.abs(endTime.diff(startTime)) / 60000
      const duration = 90;

      let ranges = []
      for(let minutes = 0; minutes <= startEndMinuteDifference - duration; minutes += duration){
        let range = {}
        range.startTime = startTime.clone().add(minutes, 'minutes')
        range.endTime = range.startTime.clone().add(duration, 'minutes')
        range.label = range.startTime.format('HH:mm') + ' - ' + range.endTime.format('HH:mm')
        range.disabled = this.datetimeIsTaken(range.startTime)
        ranges.push(range)
      }

      return ranges

    },
    selectedDate(){
      return moment(this.filters.date).startOf('day').format('YYYY-MM-DD')
    },
    selectedDatetime(){
      return this.selectedDate + ' ' + moment.unix(this.filters.appointment).format('HH:mm')
    },
    datepickerDisabledConfig(){
      return {
        customPredictor: (dateObj) => {
          let date = moment(dateObj)
          if(moment().diff(date, 'days') >= 0){
            return true;
          }
          if(this.dateIsWorkday(date) === false){
            return true
          }
          return false
        }
      }
    }
  },

  watch: {
    filters: {
      handler(filters, oldFilters){
        this.filtersChanged(filters, () => {
          if(this.filters.location && this.filters.car && (this.appointments.length === 0 || filters.date != oldFilters.date)){
            this.fetchAppointments()
          }
        })
      },
      deep: true
    }
  }

}
</script>

<style lang="scss" scoped>
@import "node_modules/bootstrap/scss/functions";
@import "node_modules/bootstrap/scss/variables";
@import "node_modules/bootstrap/scss/mixins";
.appointment-slot {
  display: block;
  float: left;
  width: calc(50% - 1rem);
  margin: .5rem;
  padding: .5rem 1rem;
  background-color: transparent;
  border: 2px solid $success;
  color: $success;
  text-align: center;
  transition: all .3s ease;
  cursor: pointer;
  &:hover {
    background-color: $success;
    color: white;
  }
  &.selected {
    background-color: $primary;
    border-color: $primary;
    color: white;
  }
  &.disabled {
    background-color: transparent;
    border: 2px solid $danger;
    color: $danger;
    cursor: not-allowed;
  }
}
.list-group-item {
  cursor: pointer;
}
.personalInfo-form {
  max-width: 500px;
  margin: 0 auto;
}
.form-group.has-error {
  color: $danger;
  input {
    border-color: $danger;
  }
}
</style>
