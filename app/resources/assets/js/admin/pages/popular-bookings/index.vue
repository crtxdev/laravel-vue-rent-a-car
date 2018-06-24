<template lang="html">
<div>
  <h1>{{ $t('popular_bookings') }}</h1>
  <div>
    <PopularBookingsWrapper />
  </div>
</div>
</template>

<script>

import PopularBookingsWrapper from '~/admin/components/popular-bookings/PopularBookingsWrapper'

export default {

  components: {
    PopularBookingsWrapper
  },

  metaInfo () {
    return { title: this.$t('popular_bookings') }
  },

  data(){
    return {

    }
  }

}

</script>

<style lang="css">
</style>
