<template lang="html">
<div>
  <div class="ref">
    <Loading v-show="loading" />
    <div :class="{ blur: loading }">
      <AppointmentsCalendar
        @loadingStart="onLoadingStart"
        @loadingEnd="onLoadingEnd"
      />
    </div>
  </div>
</div>
</template>

<script>

import Loading from '~/admin/components/datatable/Loading'
import AppointmentsCalendar from '~/admin/components/appointments/AppointmentsCalendar'
import mixin from '~/admin/components/datatable/_mixins/wrapper'

export default {

  components: {
    AppointmentsCalendar,
    Loading
  },

  mixins: [mixin]

}

</script>

<style lang="css" scoped>
.ref {
  position: relative;
}
.blur {
  -webkit-filter: blur(5px);
  -moz-filter: blur(5px);
  -o-filter: blur(5px);
  -ms-filter: blur(5px);
  filter: blur(5px);
}
</style>
