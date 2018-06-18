<template>
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">
      <router-link :to="{ name: 'home' }" class="navbar-brand">
        {{ $t('admin_panel') }}
      </router-link>

      <button class="sidebar-toggler" type="button">
        <fa icon="bars" fixed-width />
      </button>

      <div id="navbarToggler" class="collapse navbar-collapse">
        <NavbarMenu />
      </div>

    </div>
  </nav>
</template>

<script>
import NavbarMenu from './NavbarMenu'

export default {

  components: {
    NavbarMenu
  },

  data: () => ({
    appName: window.config.appName
  })

}
</script>
