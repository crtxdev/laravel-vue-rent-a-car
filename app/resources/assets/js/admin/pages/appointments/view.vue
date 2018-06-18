<template>
<div>

  <div class="row">
    <div class="col-12">
      <h1>
        {{ $t('view_appointment') }} <small>#{{ appointment._id }}</small>
      </h1>
    </div>
  </div>

  <div class="row">

    <div class="col-lg-8 m-auto">

      <form @submit.prevent="submit" @keydown="form.onKeydown($event)">

        <!-- Status -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('status') }}</label>
          <div class="col-md-7">
            <input :value="$t(form.status)" :class="{ 'is-invalid': form.errors.has('status') }" class="form-control" name="status" readonly type="text">
            <has-error :form="form" field="status"/>
          </div>
        </div>

        <!-- Location -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('location') }}</label>
          <div class="col-md-7">
            <p>{{ appointment.location.city }} - {{ appointment.location.address }}</p>
          </div>
        </div>

        <!-- Car -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('car') }}</label>
          <div class="col-md-7">
            <p>{{ appointment.car.model }}</p>
          </div>
        </div>

        <!-- First Name -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('first_name') }}</label>
          <div class="col-md-7">
            <input v-model="form.firstName" :class="{ 'is-invalid': form.errors.has('firstName') }" class="form-control" type="text" name="firstName" readonly>
            <has-error :form="form" field="firstName"/>
          </div>
        </div>

        <!-- Last Name -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('last_name') }}</label>
          <div class="col-md-7">
            <input v-model="form.lastName" :class="{ 'is-invalid': form.errors.has('lastName') }" class="form-control" type="text" name="lastName" readonly>
            <has-error :form="form" field="lastName"/>
          </div>
        </div>

        <!-- Email -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
          <div class="col-md-7">
            <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email" readonly>
            <has-error :form="form" field="email"/>
          </div>
        </div>

        <!-- License Number -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('license_number') }}</label>
          <div class="col-md-7">
            <input v-model="form.licenseNumber" :class="{ 'is-invalid': form.errors.has('licenseNumber') }" class="form-control" type="text" name="licenseNumber" readonly>
            <has-error :form="form" field="licenseNumber"/>
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

        <!-- City -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('city') }}</label>
          <div class="col-md-7">
            <input v-model="form.city" :class="{ 'is-invalid': form.errors.has('city') }" class="form-control" type="text" name="city" readonly>
            <has-error :form="form" field="city"/>
          </div>
        </div>

        <!-- ZIP -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('zip') }}</label>
          <div class="col-md-7">
            <input v-model="form.zip" :class="{ 'is-invalid': form.errors.has('zip') }" class="form-control" type="text" name="zip" readonly>
            <has-error :form="form" field="zip"/>
          </div>
        </div>

        <!-- State -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('state') }}</label>
          <div class="col-md-7">
            <input v-model="form.state" :class="{ 'is-invalid': form.errors.has('state') }" class="form-control" type="text" name="state" readonly>
            <has-error :form="form" field="state"/>
          </div>
        </div>

        <!-- Country -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('country') }}</label>
          <div class="col-md-7">
            <input v-model="form.country" :class="{ 'is-invalid': form.errors.has('country') }" class="form-control" type="text" name="country" readonly>
            <has-error :form="form" field="country"/>
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
    return { title: this.$t('view_appointment') }
  },

  data: () => ({
    appointment: {},
    form: new Form({})
  }),

  created(){
    this.loadAppointment()
  },

  methods: {
    async loadAppointment(){
      const { data } = await axios.get('/api/admin/appointments/' + this.$route.params.id)
      Vue.set(this, 'appointment', data)
      let form = new Form(data)
      Vue.set(this, 'form', form)
    }
  }
}
</script>
<style lang="scss" scoped>
  .form-control {
    &, &[readonly]{
      background-color: transparent;
      border: 0;
      -moz-appearance: textfield;
      appearance: textfield;
      &, &:focus {
        outline: none;
        box-shadow: none;
      }
    }
  }
  .form-group p {
    margin-top: 7px;
    margin-bottom: 0;
    padding-left: 12px;
  }
</style>
