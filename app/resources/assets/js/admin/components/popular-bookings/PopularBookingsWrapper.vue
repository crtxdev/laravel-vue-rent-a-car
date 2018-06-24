<template lang="html">
<div>
  <div class="ref">
    <Loading v-show="loading" />
    <div :class="{ blur: loading }">
      <PopularBookingsTable
        @loadingStart="onLoadingStart"
        @loadingEnd="onLoadingEnd"
        v-bind="$data"
      />
    </div>
  </div>
</div>
</template>

<script>

import Loading from '~/admin/components/datatable/Loading'
import PopularBookingsTable from '~/admin/components/popular-bookings/PopularBookingsTable'
import mixin from '~/admin/components/datatable/_mixins/wrapper'

export default {

  components: {
    PopularBookingsTable,
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
