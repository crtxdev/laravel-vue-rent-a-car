<template>
<div>

  <div class="row">
    <div class="col-12">
      <h1>
        {{ $t('view_user') }} <small>#{{ user._id }}</small>
      </h1>
    </div>
  </div>

  <div class="row">

    <div class="col-lg-8 m-auto">

      <form @submit.prevent @keydown="form.onKeydown($event)">

        <!-- Name -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
          <div class="col-md-7">
            <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name" readonly>
            <has-error :form="form" field="name"/>
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

        <!-- Permissions -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('permissions') }}</label>
          <div class="col-md-7">
            <ul>
              <li v-for="(permission, permissionIndex) in permissions" :key="permissionIndex" v-if="selectedPermissions[permission]">
                {{ $t('permission_' + permission.replace(/\s/g, '_')) }}
              </li>
            </ul>
            <has-error :form="form" field="permissions" />
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
    return { title: this.$t('view_user') }
  },

  data: () => ({
    user: {},
    permissions: {},
    selectedPermissions: {},
    form: new Form({})
  }),

  async created(){
    await this.loadUser()
    await this.loadPermissions()
  },

  methods: {
    async loadUser(){
      const { data } = await axios.get('/api/admin/users/' + this.$route.params.id)
      Vue.set(this, 'user', data)
      let form = new Form(data)
      Vue.set(this, 'form', form)
    },
    async loadPermissions(){
      const { data } = await axios.get('/api/admin/permissions')
      Vue.set(this, 'permissions', data)
    }
  },
  watch: {
    permissions: {
      handler(permissions){
        if(!this.user || !this.user.permissions){
          console.log('asdf')
          for(var i in permissions){
            this.$set(this.selectedPermissions, permissions[i], false)
          }
          return;
        }
        for(var i in permissions){
          this.$set(this.selectedPermissions, permissions[i], this.user.permissions.indexOf(permissions[i]) > -1)
        }
      },
      deep: true
    },
    selectedPermissions: {
      handler(selectedPermissions){
        var permissions = []
        for(var permission in selectedPermissions){
          selectedPermissions[permission] && permissions.push(permission)
        }
        this.$set(this.user, 'permissions', permissions)
        this.$set(this.form, 'permissions', permissions)
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
