<template lang="html">
<ul class="navbar-nav ml-auto">
  <!-- Authenticated -->
  <li v-if="user" class="nav-item dropdown">
    <a class="nav-link dropdown-toggle"
       href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <img :src="user.photo_url" class="rounded-circle profile-photo mr-1">
      {{ user.name }}
    </a>
    <div class="dropdown-menu">
      <a href="#" class="dropdown-item pl-3" @click.prevent="logout">
        <fa icon="sign-out-alt" fixed-width/>
        {{ $t('logout') }}
      </a>
    </div>
  </li>
</ul>
</template>

<script>

import { mapGetters } from 'vuex'

export default {

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

<style scoped>
.profile-photo {
  width: 2rem;
  height: 2rem;
  margin: -.375rem 0;
}
</style>
