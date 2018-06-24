<template>
<div class="admin-sidebar">
  <nav>
    <router-link :to="{ name: 'home' }" exact>
      <fa icon="tachometer-alt" fixed-width/>
      {{ $t('dashboard') }}
    </router-link>
    <router-link :to="{ name: 'appointments' }" v-if="hasPermission('view appointments')">
      <fa icon="list-alt" fixed-width/>
      {{ $t('appointments') }}
    </router-link>
    <router-link :to="{ name: 'popular-bookings' }" v-if="hasPermission('view appointments')">
      <fa icon="star" fixed-width/>
      {{ $t('popular_bookings') }}
    </router-link>
    <router-link :to="{ name: 'locations' }" v-if="hasPermission('view locations')">
      <fa icon="location-arrow" fixed-width/>
      {{ $t('locations') }}
    </router-link>
    <router-link :to="{ name: 'cars' }" v-if="hasPermission('view cars')">
      <fa icon="car" fixed-width/>
      {{ $t('cars') }}
    </router-link>
    <router-link :to="{ name: 'users' }" v-if="hasPermission('view users')">
      <fa icon="users" fixed-width/>
      {{ $t('users') }}
    </router-link>
  </nav>
</div>
</template>

<script>
import { mapGetters } from 'vuex'
import permissionMixin from '~/admin/components/_mixins/permission'

export default {

  mixins: [permissionMixin],

  data: () => ({
    appName: window.config.appName
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      window.location.href = '/'
    }
  }

}
</script>

<style lang="scss">
</style>
