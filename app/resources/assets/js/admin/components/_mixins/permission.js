import { mapGetters } from 'vuex'

export default {
  methods: {
    hasPermission(permission){
      return this.loggedInUser.permissions.indexOf(permission) > -1;
    }
  },
  computed: mapGetters({
    loggedInUser: 'auth/user'
  })
}
