<template lang="html">
<div>
  <full-calendar :event-sources="eventSources" :config="config" />
</div>
</template>

<script>

import Vue from 'vue'
import axios from 'axios'
import i18n from '~/admin/plugins/i18n'

export default {
  data: () => ({
    eventSources: [],
    config: {
      locale: 'sr',
      schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
      resourceLabelText: i18n.t('locations'),
      editable: false,
      handleWindowResize: true,
      weekends: false,
      defaultView: 'timelineDay',
      minTime: '07:00:00',
      maxTime: '19:00:00',
      displayEventTime: true,
      header: {
        right: 'timelineDay,agendaWeek,month,listWeek'
      },
      resources: []
    }
  }),
  async created(){
    await this.loadResources()
    Vue.set(this, 'eventSources', [{
      events: async (start, end, timezone, callback) => {
        let dateFormat = 'YYYY-MM-DD HH:mm'
        let startDate = start.format(dateFormat)
        let endDate = end.format(dateFormat)
        this.$emit('loadingStart')
        const { data } = await axios.get(`/api/admin/calendar/events/${startDate}/${endDate}`)
        callback(data)
        this.$emit('loadingEnd')
      }
    }]);
  },
  methods: {
    async loadResources(){
      const { data } = await axios.get(`/api/admin/calendar/resources`)
      Vue.set(this.config, 'resources', data)
    }
  }
}

</script>

<style lang="css">
</style>
