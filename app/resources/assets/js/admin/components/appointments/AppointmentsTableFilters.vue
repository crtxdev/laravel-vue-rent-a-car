<template lang="html">
<div class="abs">
  <div class="btn-group" name="HeaderSettings">

    <div>
      <button data-toggle="dropdown" class="btn btn-secondary dropdown-toggle" type="button">
        <fa icon="car" fixed-width />
        <fa icon="caret-down" fixed-width />
      </button>
      <div class="dropdown-menu keep-open clearfix">
        <a
          href="#"
          class="dropdown-item text-muted"
          @click.prevent="removeFilter('car')"
        >{{ $t('all_cars') }}</a>
        <a
          class="dropdown-item"
          href="#"
          v-for="(car, carIndex) in cars"
          :key="carIndex"
          @click.prevent="setFilter('car', car._id)
        ">{{ car.model }}</a>
      </div>
    </div>

    <div>
      <button data-toggle="dropdown" class="btn btn-secondary dropdown-toggle" type="button">
        <fa icon="location-arrow" fixed-width />
        <fa icon="caret-down" fixed-width />
      </button>
      <div class="dropdown-menu keep-open clearfix">
        <a
          href="#"
          class="dropdown-item text-muted"
          @click.prevent="removeFilter('location')"
        >{{ $t('all_locations') }}</a>
        <a
          class="dropdown-item"
          href="#"
          v-for="(location, locationIndex) in locations"
          :key="locationIndex"
          @click.prevent="setFilter('location', location._id)
        ">{{ location.city }} - {{ location.address }}</a>
      </div>
    </div>

    <div>
      <button data-toggle="dropdown" class="btn btn-secondary dropdown-toggle" type="button">
        <fa icon="calendar-alt" fixed-width />
        <fa icon="caret-down" fixed-width />
      </button>
      <div class="dropdown-menu keep-open clearfix">
        <datepicker
          v-model="datepickerDate"
          :inline="true"
          :monday-first="true"
          maximum-view="month"
          :full-month-name="true"
          language="sr"
          :bootstrap-styling="true"
          class="rental-datepicker"
          @selected="onDatepickerSelected"
        ></datepicker>
        <button type="button" class="btn btn-default btn-block btn-sm" @click.prevent="removeFilter('datetime')">{{ $t('remove_filter') }}</button>
      </div>
    </div>

  </div>
</div>
</template>

<script>

import Vue from 'vue'
import axios from 'axios'
import moment from 'moment'
import Datepicker from 'vuejs-datepicker'

export default {
  components: {
    Datepicker
  },
  data(){
    return {
      cars: [],
      locations: [],
      filters: {
        datetime: null,
        car: null,
        location: null
      },
      datepickerDate: new Date()
    }
  },
  async created(){
    await this.loadLocations()
    await this.loadCars()
  },
  methods: {
    async loadLocations(){
      const { data } = await axios.get('/api/locations')
      Vue.set(this, 'locations', data)
    },
    async loadCars(){
      const { data } = await axios.get('/api/cars')
      Vue.set(this, 'cars', data)
    },
    setFilter(key, val){
      Vue.set(this.filters, key, val)
      this.$emit('change', this.filters)
      this.closeDropdowns()
    },
    removeFilter(key){
      this.setFilter(key, null)
    },
    closeDropdowns(){
      $(this.$el).find('.dropdown-menu.show').each((i, el) => {
        $(el).removeClass('show').dropdown('toggle')
      })
    },
    onDatepickerSelected(date){
      this.setFilter('datetime', moment(date).format('YYYY-MM-DD'))
      this.datepickerDate = new Date()
    }
  }
}
</script>

<style lang="scss" scoped>
.abs {
  position: absolute;
  left: 0;
}
.btn-group {
  .btn {
    margin-right: 15px;
  }
}
.dropdown-menu {
  padding: 0;
}
</style>
