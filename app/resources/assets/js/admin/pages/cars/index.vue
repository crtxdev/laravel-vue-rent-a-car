<template lang="html">
<div>
  <h1>{{ $t('cars') }}</h1>
  <div>
    <CarsWrapper />
  </div>
</div>
</template>

<script>

import CarsWrapper from '~/admin/components/cars/CarsWrapper'

export default {

  components: {
    CarsWrapper
  },

  metaInfo () {
    return { title: this.$t('cars') }
  },

  data(){
    return {

    }
  }

}

</script>

<style lang="css">
</style>
