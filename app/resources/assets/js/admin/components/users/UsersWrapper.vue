<template lang="html">
<div>
  <div class="ref">
    <Loading v-show="loading" />
    <div class="btn-group" name="HeaderSettings">
      <div>
        <router-link :to="{ name: 'users.create' }" class="btn btn-secondary" v-if="hasPermission('create users')">
          <fa icon="plus" fixed-width />
          {{ $t('new_user') }}
        </router-link>
      </div>
    </div>
    <div :class="{ blur: loading }">
      <UsersTable
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
import UsersTable from '~/admin/components/users/UsersTable'
import mixin from '~/admin/components/datatable/_mixins/wrapper'
import permissionMixin from '~/admin/components/_mixins/permission'

export default {

  components: {
    UsersTable,
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
