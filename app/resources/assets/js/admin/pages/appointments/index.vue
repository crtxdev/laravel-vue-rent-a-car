<template lang="html">
<div>
  <h1>{{ $t('appointments') }}</h1>
  <div>
    <AppointmentsWrapper />
  </div>
</div>
</template>

<script>

import AppointmentsWrapper from '~/admin/components/appointments/AppointmentsWrapper'

export default {

  components: {
    AppointmentsWrapper
  },

  metaInfo () {
    return { title: this.$t('appointments') }
  },

  data(){
    return {

    }
  }

}

</script>

<style lang="css">
</style>
