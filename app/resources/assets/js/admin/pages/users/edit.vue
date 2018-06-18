<template>
<div>

  <div class="row">
    <div class="col-12">
      <h1>
        {{ $t('edit_user') }} <small>#{{ user._id }}</small>
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
              {{ $t('update') }}
            </v-button>

            <button type="button" class="btn btn-danger" @click="confirmDelete" :disabled="form.busy" v-if="hasPermission('delete users')">
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
    return { title: this.$t('edit_user') }
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
    },
    async submit () {
      Vue.set(this.form, 'busy', true)
      const { data } = await this.form.put('/api/admin/users/' + this.user._id)
      Vue.set(this.form, 'busy', false)
      swal(this.$t('success_update'), this.$t('user_saved_message'), 'success')
    },
    async delete () {
      await axios.delete('/api/admin/users/' + this.user._id)
    },
    async confirmDelete() {
      swal({
        type: 'warning',
        title: this.$t('are_you_sure_delete'),
        html: this.$t('user_delete_warning_message'),
        showCancelButton: true,
        cancelButtonText: this.$t('no'),
        confirmButtonText: this.$t('yes')
      }).then( async (result) => {
        if(result.value && !result.dismiss){
          await this.delete()
          swal(this.$t('success_delete'), this.$t('user_deleted_message'), 'success')
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
