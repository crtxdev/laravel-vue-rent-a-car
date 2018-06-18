<template>
  <div>
    <div class="row">
      <div class="col-sm-4">
        <div class="panel-box">
          <fa icon="location-arrow" fixed-width/>
          <strong>{{ $t('locations') }}</strong>
          <span>{{ stats.totalLocations }}</span>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="panel-box">
          <fa icon="car" fixed-width/>
          <strong>{{ $t('cars') }}</strong>
          <span>{{ stats.totalCars }}</span>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="panel-box">
          <fa icon="list-alt" fixed-width/>
          <strong>{{ $t('appointments') }}</strong>
          <span>{{ stats.totalAppointments }}</span>
        </div>
      </div>
    </div>
    <div>
      <div class="mt-4">
        <h2 class="mb-4 text-center chart-title">{{ $t('last_week_appointments') }}</h2>
        <LastWeekAppointmentsChart
          class="last-week-appointments-chart"
          chart-id="last-week-appointments-chart"
          v-if="stats.lastWeekAppointments != null"
          :data="lastWeekAppointmentsChartData"
          :options="{ responsive: true, maintainAspectRatio: false }"
          :height="300"
        />
      </div>
    </div>
  </div>
</template>

<script>

import Vue from 'vue'
import axios from 'axios'
import i18n from '~/admin/plugins/i18n'
import moment from 'moment'
import LastWeekAppointmentsChart from '~/admin/components/stats/LastWeekAppointmentsChart'

export default {

  components: {
    LastWeekAppointmentsChart
  },

  metaInfo() {
    return { title: this.$t('home') }
  },

  data: () => ({
    stats: {
      totalCars: null,
      totalLocations: null,
      totalAppointments: null,
      lastWeekAppointments: null
    }
  }),

  created(){
    this.loadStats()
  },

  methods: {
    async loadStats(){
      const { data } = await axios.get(`/api/admin/stats`)
      Vue.set(this, 'stats', data)
    }
  },

  computed: {
    lastWeekAppointmentsChartData(){
      let st = this.stats.lastWeekAppointments
      let labels = Object.keys(st).map((dateStr) => {
        let date = moment(dateStr, 'YYYY-MM-DD')
        if(date.startOf('day').isSame(moment().startOf('day'))){
          return i18n.t('today') + ', ' + date.format('Do MMM')
        }
        return date.format('dddd, Do MMM')
      })
      let data = {
        labels,
        datasets: [
          {
            label: i18n.t('reserved_plural'),
            backgroundColor: '#484376',
            borderColor: '#484376',
            fill: false,
            data: []
          },
          {
            label: i18n.t('completed_plural'),
            backgroundColor: '#28a745',
            borderColor: '#28a745',
            fill: false,
            data: []
          },
          {
            label: i18n.t('cancelled_plural'),
            backgroundColor: '#b03468',
            borderColor: '#b03468',
            fill: false,
            data: []
          }
        ]
      }
      for(let date in st){
        data.datasets[0].data.push(st[date].reserved)
        data.datasets[1].data.push(st[date].completed)
        data.datasets[2].data.push(st[date].cancelled)
      }
      return data
    }
  }

}
</script>

<style lang="css">
  .last-week-appointments-chart {
    width: 100%;
    height: 300px;
  }
  .chart-title {
    text-transform: uppercase;
    font-size: 20px;
    color: #444;
  }
</style>