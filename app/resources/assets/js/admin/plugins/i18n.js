import Vue from 'vue'
import store from '~/admin/store'
import VueI18n from 'vue-i18n'
import moment from 'moment'

Vue.use(VueI18n)

const i18n = new VueI18n({
  locale: 'sr',
  messages: {}
})

moment.locale('sr')

/**
 * @param {String} locale
 */
export async function loadMessages (locale) {
  if (Object.keys(i18n.getLocaleMessage(locale)).length === 0) {
    const baseMessages = await import(/* webpackChunkName: "lang-[request]" */ `~/lang/${locale}`)
    const adminMessages = await import(/* webpackChunkName: "lang-[request]" */ `~/admin/lang/${locale}`)
    const messages = { ...baseMessages, ...adminMessages }
    i18n.setLocaleMessage(locale, messages)
  }

  if (i18n.locale !== locale) {
    i18n.locale = locale
  }
}

;(async function () {
  await loadMessages(store.getters['lang/locale'])
})()

export default i18n
