<template>
<div>

  <div class="row">
    <div class="col-12">
      <h1>
        {{ $t('new_user') }}
      </h1>
    </div>
  </div>

  <div class="row">

    <div class="col-lg-8 m-auto">

      <form @submit.prevent="submit" @keydown="form.onKeydown($event)">

        <!-- Name -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
          <div class="col-md-7">
            <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name">
            <has-error :form="form" field="name"/>
          </div>
        </div>

        <!-- Email -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
          <div class="col-md-7">
            <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email">
            <has-error :form="form" field="email"/>
          </div>
        </div>

        <!-- Password -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('password') }}</label>
          <div class="col-md-7">
            <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password">
            <has-error :form="form" field="password"/>
          </div>
        </div>

        <!-- Permissions -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('permissions') }}</label>
          <div class="col-md-7">
            <ul class="list-unstyled">
              <li v-for="(permission, permissionIndex) in permissions" :key="permissionIndex">
                <checkbox v-model="selectedPermissions[permission]" :name="'selectedPermissions[' + permission + ']'">
                  {{ $t('permission_' + permission.replace(/\s/g, '_')) }}
                </checkbox>
              </li>
            </ul>
            <has-error :form="form" field="permissions" />
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-7 offset-md-3 d-flex actions">
            <!-- Submit Button -->
            <v-button :loading="form.busy">
              <fa icon="save" fixed-width />
              {{ $t('create') }}
            </v-button>

            <button type="button" class="btn btn-default" @click="confirmCancel" :disabled="form.busy">
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
import permissionMixin from '~/admin/components/_mixins/permission'

export default {

  mixins: [permissionMixin],

  metaInfo () {
    return { title: this.$t('new_user') }
  },

  data: () => ({
    user: {},
    permissions: {},
    selectedPermissions: {},
    form: new Form({})
  }),

  async created(){
    await this.loadPermissions()
  },

  methods: {
    async loadPermissions(){
      const { data } = await axios.get('/api/admin/permissions')
      Vue.set(this, 'permissions', data)
    },
    async submit () {
      Vue.set(this.form, 'busy', true)
      const { data } = await this.form.post('/api/admin/users')
      Vue.set(this.form, 'busy', false)
      swal({
        type: 'success',
        title: this.$t('success_create'),
        html: this.$t('user_created_message')
      }).then( async (result) => {
        this.$router.push({ name: 'users' })
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
          this.$router.push({ name: 'users' })
        }
      })
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
<style media="screen">
  .actions {
    justify-content: space-between;
  }
</style>
