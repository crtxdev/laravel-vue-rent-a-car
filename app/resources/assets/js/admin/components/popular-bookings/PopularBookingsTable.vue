<template>
<div>
  <PopularBookingsExport />
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
import PopularBookingsExport from '~/admin/components/popular-bookings/PopularBookingsExport'
import i18n from '~/admin/plugins/i18n'
import mixin from '~/admin/components/datatable/_mixins/table'

export default {

  components: {
    AbstractDatatable,
    PopularBookingsExport
  },

  mixins: [mixin],

  data: () => ({
    endpoint: '/api/admin/popular-bookings',
    loading: false,
    columns: [
      { title: 'ID', field: '_id', sortable: false },
      { title: i18n.t('car'), field: 'car', sortable: false },
      { title: i18n.t('location'), field: 'location', sortable: false },
      { title: i18n.t('total_booked'), field: 'count', sortable: true }
    ],
    data: [],
    total: 0,
    query: {
      sort: 'count',
      order: 'desc',
      filters: {}
    }
  })

}

</script>
