<template>
<div>

  <div class="row">
    <div class="col-12">
      <h1>
        {{ $t('edit_location') }} <small>#{{ location._id }}</small>
      </h1>
    </div>
  </div>

  <div class="row">

    <div class="col-lg-8 m-auto">

      <form @submit.prevent="submit" @keydown="form.onKeydown($event)">

        <!-- City -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('city') }}</label>
          <div class="col-md-7">
            <input v-model="form.city" :class="{ 'is-invalid': form.errors.has('city') }" class="form-control" type="text" name="city">
            <has-error :form="form" field="city"/>
          </div>
        </div>

        <!-- Address -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('address') }}</label>
          <div class="col-md-7">
            <input v-model="form.address" :class="{ 'is-invalid': form.errors.has('address') }" class="form-control" type="text" name="address">
            <has-error :form="form" field="address"/>
          </div>
        </div>

        <!-- Cars -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('available_cars') }}</label>
          <div class="col-md-7">
            <ul class="list-unstyled">
              <li v-for="(car, carIndex) in cars" :key="carIndex">
                <checkbox v-model="selectedCars[car._id]" :name="'selectedCars[' + car._id + ']'">
                  {{ car.model }}
                </checkbox>
              </li>
            </ul>
            <has-error :form="form" field="availableCars" />
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-7 offset-md-3 d-flex actions">
            <!-- Submit Button -->
            <v-button :loading="form.busy">
              <fa icon="save" fixed-width />
              {{ $t('update') }}
            </v-button>

            <button type="button" class="btn btn-danger" @click="confirmDelete" :disabled="form.busy" v-if="hasPermission('delete locations')">
              <fa icon="trash-alt" fixed-width />
              {{ $t('delete') }}
            </button>

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
import permissionMixin from '~/admin/components/_mixins/permission'

export default {

  mixins: [permissionMixin],

  metaInfo () {
    return { title: this.$t('edit_location') }
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
    },
    async submit () {
      Vue.set(this.form, 'busy', true)
      const { data } = await this.form.put('/api/admin/locations/' + this.location._id)
      Vue.set(this.form, 'busy', false)
      swal(this.$t('success_update'), this.$t('location_saved_message'), 'success')
    },
    async delete () {
      await axios.delete('/api/admin/locations/' + this.location._id)
    },
    async confirmDelete() {
      swal({
        type: 'warning',
        title: this.$t('are_you_sure_delete'),
        html: this.$t('location_delete_warning_message'),
        showCancelButton: true,
        cancelButtonText: this.$t('no'),
        confirmButtonText: this.$t('yes')
      }).then( async (result) => {
        if(result.value && !result.dismiss){
          await this.delete()
          swal(this.$t('success_delete'), this.$t('location_deleted_message'), 'success')
          this.$router.push({ name: 'locations' })
        }
      })
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
<style media="screen">
  .actions {
    justify-content: space-between;
  }
</style>
