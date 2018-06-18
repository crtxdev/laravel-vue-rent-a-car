<template>
<div>
  <AbstractDatatable
    @update="onDataUpdated"
    @loadingStart="onLoadingStart"
    @loadingEnd="onLoadingEnd"
    v-bind="$data"
  />
</div>
</template>

<script>

import AbstractDatatable from '~/admin/components/datatable/AbstractDatatable'
import i18n from '~/admin/plugins/i18n'
import mixin from '~/admin/components/datatable/_mixins/table'

export default {

  components: {
    AbstractDatatable
  },

  mixins: [mixin],

  data: () => ({
    endpoint: '/api/admin/locations',
    loading: false,
    columns: [
      { title: 'ID', field: '_id', sortable: false },
      { title: i18n.t('city'), field: 'city', sortable: false },
      { title: i18n.t('address'), field: 'address', sortable: false },
      { title: i18n.t('location_created_at'), field: 'created_at', sortable: true },
      { title: '', field: 'actions', sortable: false }
    ],
    data: [],
    total: 0,
    query: {
      sort: 'created_at',
      order: 'desc',
      filters: {}
    }
  })

}

</script>
