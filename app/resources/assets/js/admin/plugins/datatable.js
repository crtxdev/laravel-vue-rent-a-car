import Vue from 'vue'
import locale from '~/plugins/datatable/locale/sr-rs'
Vue.prototype.$i18nForDatatable = srcTxt => locale[srcTxt] || srcTxt
