<script>

import BaseDatatable from '~/plugins/datatable'
import props from './props'
import { debounce, cloneDeep } from 'lodash'
import axios from 'axios'

export default {
  name: 'Datatable',
  extends: BaseDatatable,
  props,
  methods: {
    onQueryChanged: debounce( async (this_, query) => {
      this_.$emit('loadingStart')
      const { data } = await axios.get(this_.endpoint, {
        params: this_.adaptedQuery
      })
      let items = data.data
      this_.$emit('update', {
        total: data.recordsTotal,
        data: items
      })
      this_.$emit('loadingEnd')
    }, 300),
    onFiltersChanged(filters){
      this.$set(this.query, 'filters', filters)
    }
  },
  computed: {
    adaptedQuery(){

      let query = cloneDeep(this.query)
      let sortColIndex = 0
      for(let i in this.columns){
        if(this.columns[i].field == query.sort){
          sortColIndex = i
        }
      }
      query['order[0][column]'] = parseInt(sortColIndex)
      query['order[0][dir]'] = query.order
      delete query.sort
      delete query.order

      query.start = query.offset
      query.length = query.limit
      delete query.offset
      delete query.limit

      let columns = []
      for(let i in this.columns){
        let column = this.columns[i]
        let columnData = {
          data: column.field,
          name: column.field,
          orderable: column.sortable,
          searchable: true
        }
        for(let prop in columnData){
          query[`columns[${i}][${prop}]`] = columnData[prop]
        }
      }
      query.columns = columns

      if(query.filters){
        let filters = query.filters
        delete query.filters
        if(filters && Object.keys(filters).length){
          query.filters = {}
          for(let i in filters){
            query.filters[i] = filters[i]
          }
        }
      }

      if(query.filters){
        for(let key in query.filters){
          if(query.filters[key]){
            query[`filters[${key}]`] = query.filters[key]
          }
        }
        delete query.filters
      }

      return query

    }
  },
  watch: {
    query: {
      async handler (query) {
        this.onQueryChanged(this, query)
      },
      deep: true
    }
  }
}
</script>

<style lang="css">
</style>
