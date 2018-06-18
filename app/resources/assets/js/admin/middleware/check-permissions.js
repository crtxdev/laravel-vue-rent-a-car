import store from '~/admin/store'

export default async (to, from, next) => {
  if (!store.getters['auth/check']) {
    next({ name: 'home' })
  } else {
    if(to.meta && to.meta.permissions){
      let user = store.getters['auth/user']
      let hasAccess = true
      for(let routePermission of to.meta.permissions){
        if(user.permissions.indexOf(routePermission) === -1){
          hasAccess = false
          break;
        }
      }
      if(hasAccess){
        next()
      } else {
        next({ name: 'home' })
      }
    } else {
      next()
    }
  }
}
