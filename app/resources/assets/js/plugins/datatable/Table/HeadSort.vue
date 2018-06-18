<template>
  <a href="#" @click.prevent="handleClick" name="HeadSort">
    <fa :icon="`sort-amount-${this.order ? (this.order == 'desc' ? 'down' : 'up') : 'down'}`" :style="{ opacity: this.order ? 1 : 0.25 }" fixed-width />
  </a>
</template>
<script>
/**
 * Sorting arrows within <th>
 */
export default {
  name: 'HeadSort',
  props: {
    field: { type: String, required: true },
    query: { type: Object, required: true }
  },
  data: () => ({
    order: ''
  }),
  watch: {
    query: {
      handler ({ sort: field, order }) {
        this.order = field === this.field ? order : ''
      },
      deep: true,
      immediate: true
    }
  },
  methods: {
    handleClick () {
      const { query, order } = this
      query.sort = this.field
      query.order = this.order = order === 'desc' ? 'asc' : 'desc'
    }
  }
}
</script>
<style scoped>
  svg path {
    fill: black;
  }
</style>
