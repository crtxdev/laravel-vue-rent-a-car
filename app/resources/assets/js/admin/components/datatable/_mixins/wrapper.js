export default {
  data: () => ({
    loading: true
  }),
  methods: {
    onLoadingStart(){
      this.loading = true
    },
    onLoadingEnd(){
      this.loading = false
    }
  }
}
