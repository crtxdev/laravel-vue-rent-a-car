export default {
  methods: {
    onFiltersChanged(filters){
      this.$set(this.query, 'filters', filters)
    },
    onDataUpdated(args){
      for(var i in args){
        this.$set(this, i, args[i])
      }
    },
    onLoadingStart(){
      this.$emit('loadingStart')
    },
    onLoadingEnd(){
      this.$emit('loadingEnd')
    }
  }
}
