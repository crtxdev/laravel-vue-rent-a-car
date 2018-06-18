<template lang="html">
<div>
  <div class="ref">
    <Loading v-show="loading" />
    <div class="btn-group" name="HeaderSettings">
      <div>
        <router-link :to="{ name: 'locations.create' }" class="btn btn-secondary" v-if="hasPermission('create locations')">
          <fa icon="plus" fixed-width />
          {{ $t('new_location') }}
        </router-link>
      </div>
    </div>
    <div :class="{ blur: loading }">
      <LocationsTable
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
import LocationsTable from '~/admin/components/locations/LocationsTable'
import mixin from '~/admin/components/datatable/_mixins/wrapper'
import permissionMixin from '~/admin/components/_mixins/permission'

export default {

  components: {
    LocationsTable,
    Loading
  },

  mixins: [mixin, permissionMixin]

}

</script>

<style lang="css" scoped>
.ref {
  position: relative;
}
.btn-group {
  position: absolute;
  top: 0;
}
.blur {
  -webkit-filter: blur(5px);
  -moz-filter: blur(5px);
  -o-filter: blur(5px);
  -ms-filter: blur(5px);
  filter: blur(5px);
}
</style>
