import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'
import VTooltip from 'v-tooltip'

import '~/plugins'
import '~/components'

Vue.config.productionTip = false

/* eslint-disable no-new */
Vue.use(VTooltip)
new Vue({
  i18n,
  store,
  router,
  ...App
})
