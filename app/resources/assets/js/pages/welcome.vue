<template>
  <div>
    <div class="top-right links">
      <template v-if="!authenticated">
        <router-link :to="{ name: 'login' }">
          {{ $t('login') }}
        </router-link>
        <router-link :to="{ name: 'register' }">
          {{ $t('register') }}
        </router-link>
      </template>
    </div>

    <div class="text-center">
      <div class="subtitle mb-2">
        {{ $t('welcome_to') }}
      </div>
      <div class="title mb-4">
        {{ title }}
      </div>
      <div class="links">
        <router-link :to="{ name: 'rental' }">{{ $t('see_offers') }}</router-link>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  layout: 'welcome',

  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: window.config.appName
  }),

  computed: mapGetters({
    authenticated: 'auth/check'
  })
}
</script>

<style scoped>
.top-right {
  position: absolute;
  right: 10px;
  top: 18px;
}
.title {
  font-size: 85px;
}
.subtitle {
  font-size: 42px;
}
</style>
