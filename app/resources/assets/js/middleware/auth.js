import store from '~/store'

export default async (to, from, next) => {
  if (!store.getters['auth/check']) {
    window.location.href = '/login'
  } else {
    next()
  }
}
