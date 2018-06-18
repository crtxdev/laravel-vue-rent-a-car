<template>
<div>

  <div class="row">
    <div class="col-12">
      <h1>
        {{ $t('new_car') }}
      </h1>
    </div>
  </div>

  <div class="row">

    <div class="col-lg-8 m-auto">

      <form @submit.prevent="submit" @keydown="form.onKeydown($event)">

        <!-- City -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('model') }}</label>
          <div class="col-md-7">
            <input v-model="form.model" :class="{ 'is-invalid': form.errors.has('model') }" class="form-control" type="text" name="model">
            <has-error :form="form" field="model"/>
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-7 offset-md-3 d-flex actions">
            <!-- Submit Button -->
            <v-button :loading="form.busy">
              <fa icon="save" fixed-width />
              {{ $t('create') }}
            </v-button>

            <button type="button" class="btn btn-danger" @click="confirmCancel" :disabled="form.busy">
              <fa icon="times" fixed-width />
              {{ $t('cancel') }}
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

export default {

  metaInfo () {
    return { title: this.$t('new_car') }
  },

  data: () => ({
    car: {},
    form: new Form({})
  }),

  created(){
  },

  methods: {
    async submit () {
      Vue.set(this.form, 'busy', true)
      const { data } = await this.form.post('/api/admin/cars')
      Vue.set(this.form, 'busy', false)
      swal({
        type: 'success',
        title: this.$t('success_create'),
        html: this.$t('car_created_message')
      }).then( async (result) => {
        this.$router.push({ name: 'cars' })
      })
    },
    async confirmCancel() {
      swal({
        type: 'warning',
        title: this.$t('are_you_sure_cancel'),
        showCancelButton: true,
        cancelButtonText: this.$t('no'),
        confirmButtonText: this.$t('yes')
      }).then( async (result) => {
        if(result.value && !result.dismiss){
          this.$router.push({ name: 'cars' })
        }
      })
    }
  }
}
</script>
<style media="screen">
  .actions {
    justify-content: space-between;
  }
</style>
