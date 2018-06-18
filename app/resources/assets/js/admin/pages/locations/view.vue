<template>
<div>

  <div class="row">
    <div class="col-12">
      <h1>
        {{ $t('view_location') }} <small>#{{ location._id }}</small>
      </h1>
    </div>
  </div>

  <div class="row">

    <div class="col-lg-8 m-auto">

      <form @submit.prevent @keydown="form.onKeydown($event)">

        <!-- City -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('city') }}</label>
          <div class="col-md-7">
            <input v-model="form.city" :class="{ 'is-invalid': form.errors.has('city') }" class="form-control" type="text" name="city" readonly>
            <has-error :form="form" field="city"/>
          </div>
        </div>

        <!-- Address -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('address') }}</label>
          <div class="col-md-7">
            <input v-model="form.address" :class="{ 'is-invalid': form.errors.has('address') }" class="form-control" type="text" name="address" readonly>
            <has-error :form="form" field="address"/>
          </div>
        </div>

        <!-- Cars -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('available_cars') }}</label>
          <div class="col-md-7">
            <ul>
              <li v-for="(car, carIndex) in cars" v-if="selectedCars[car._id]" :key="carIndex">
                {{ car.model }}
              </li>
            </ul>
            <has-error :form="form" field="availableCars" />
          </div>
        </div>

      </form>

    </div>
  </div>
</div>
</template>
<script type="text/javascript">

import Vue from 'vue'
import axios from 'axios'
import Form from 'vform'
import swal from 'sweetalert2'

export default {

  metaInfo () {
    return { title: this.$t('view_location') }
  },

  data: () => ({
    location: {},
    cars: {},
    selectedCars: {},
    form: new Form({})
  }),

  created(){
    this.loadLocation()
    this.loadCars()
  },

  methods: {
    async loadLocation(){
      const { data } = await axios.get('/api/admin/locations/' + this.$route.params.id)
      Vue.set(this, 'location', data)
      let form = new Form(data)
      Vue.set(this, 'form', form)
    },
    async loadCars(){
      const { data } = await axios.get('/api/admin/cars')
      Vue.set(this, 'cars', data.data)
    }
  },
  watch: {
    cars: {
      handler(cars){
        for(var i in cars){
          this.$set(this.selectedCars, cars[i]._id, this.location.availableCars.indexOf(cars[i]._id) > -1)
        }
      },
      deep: true
    },
    selectedCars: {
      handler(selectedCars){
        var ids = []
        for(var id in selectedCars){
          selectedCars[id] && ids.push(id)
        }
        this.$set(this.location, 'availableCars', ids)
        this.$set(this.form, 'availableCars', ids)
      },
      deep: true
    }
  }
}
</script>
<style lang="scss">
.form-control {
  &, &[readonly]{
    background-color: transparent;
    border: 0;
    &, &:focus {
      outline: none;
      box-shadow: none;
    }
  }
}
ul {
  padding-left: 25px;
  padding-top: 5px;
}
</style>
