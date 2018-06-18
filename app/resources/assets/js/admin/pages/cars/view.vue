<template>
<div>

  <div class="row">
    <div class="col-12">
      <h1>
        {{ $t('view_car') }} <small>#{{ car._id }}</small>
      </h1>
    </div>
  </div>

  <div class="row">

    <div class="col-lg-8 m-auto">

      <form @submit.prevent @keydown="form.onKeydown($event)">

        <!-- City -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('model') }}</label>
          <div class="col-md-7">
            <input v-model="form.model" :class="{ 'is-invalid': form.errors.has('model') }" class="form-control" type="text" name="model" readonly>
            <has-error :form="form" field="model"/>
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

export default {

  metaInfo () {
    return { title: this.$t('view_car') }
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
    }
  }
}
</script>
<style lang="scss" scoped>
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
</style>
