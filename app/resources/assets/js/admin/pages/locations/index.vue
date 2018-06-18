<template lang="html">
<div>
  <h1>{{ $t('locations') }}</h1>
  <div>
    <LocationsWrapper />
  </div>
</div>
</template>

<script>

import LocationsWrapper from '~/admin/components/locations/LocationsWrapper'

export default {

  components: {
    LocationsWrapper
  },

  metaInfo () {
    return { title: this.$t('locations') }
  },

  data(){
    return {

    }
  }

}

</script>

<style lang="css">
</style>
