<template>
<div>
  <AppointmentsTableFilters @change="onFiltersChanged" />
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
import AppointmentsTableFilters from './AppointmentsTableFilters'
import i18n from '~/admin/plugins/i18n'
import mixin from '~/admin/components/datatable/_mixins/table'

export default {

  components: {
    AppointmentsTableFilters,
    AbstractDatatable
  },

  mixins: [mixin],

  data: () => ({
    endpoint: '/api/admin/appointments',
    loading: false,
    columns: [
      { title: 'ID', field: '_id', sortable: false },
      { title: i18n.t('first_name'), field: 'firstName', sortable: false },
      { title: i18n.t('last_name'), field: 'lastName', sortable: false },
      { title: i18n.t('car'), field: 'car', sortable: false },
      { title: i18n.t('location'), field: 'location', sortable: false },
      { title: i18n.t('appointment'), field: 'datetime', sortable: true },
      { title: i18n.t('appointment_created_at'), field: 'created_at', sortable: true },
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
