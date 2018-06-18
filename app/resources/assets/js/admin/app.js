import Vue from 'vue'
import store from '~/admin/store'
import router from '~/admin/router'
import i18n from '~/admin/plugins/i18n'
import App from '~/admin/components/App'
import VTooltip from 'v-tooltip'
import $ from 'jquery'

window.$ = window.jQuery = $;

import '~/admin/plugins'
import '~/admin/components'

Vue.config.productionTip = false

/* eslint-disable no-new */
Vue.use(VTooltip)
new Vue({
  i18n,
  store,
  router,
  ...App
})
