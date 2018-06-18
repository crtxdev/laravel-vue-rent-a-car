<template>
<div>

  <div class="row">
    <div class="col-12">
      <h1>
        {{ $t('edit_car') }} <small>#{{ car._id }}</small>
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
              {{ $t('update') }}
            </v-button>

            <button type="button" class="btn btn-danger" @click="confirmDelete" :disabled="form.busy" v-if="hasPermission('delete cars')">
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
    return { title: this.$t('edit_car') }
  },

  data: () => ({
    car: {},
    form: new Form({})
  }),

  created(){
    this.loadCar()
  },

  methods: {
    async loadCar(){
      const { data } = await axios.get('/api/admin/cars/' + this.$route.params.id)
      Vue.set(this, 'car', data)
      let form = new Form(data)
      Vue.set(this, 'form', form)
    },
    async submit () {
      Vue.set(this.form, 'busy', true)
      const { data } = await this.form.put('/api/admin/cars/' + this.car._id)
      Vue.set(this.form, 'busy', false)
      swal(this.$t('success_update'), this.$t('car_saved_message'), 'success')
    },
    async delete () {
      await axios.delete('/api/admin/cars/' + this.car._id)
    },
    async confirmDelete() {
      swal({
        type: 'warning',
        title: this.$t('are_you_sure_delete'),
        html: this.$t('car_delete_warning_message'),
        showCancelButton: true,
        cancelButtonText: this.$t('no'),
        confirmButtonText: this.$t('yes')
      }).then( async (result) => {
        if(result.value && !result.dismiss){
          await this.delete()
          swal(this.$t('success_delete'), this.$t('car_deleted_message'), 'success')
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
