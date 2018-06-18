<template>
  <label name="PageSizeSelect">
    <span>
      <button data-toggle="dropdown" class="btn btn-sm btn-primary dropdown-toggle" type="button">
        {{ query.limit }}
        <fa icon="caret-down" fixed-width />
      </button>
      <div class="dropdown-menu clearfix">
        <a
          v-for="(size, sizeIndex) in pageSizeOptions"
          :key="sizeIndex"
          class="dropdown-item"
          :class="{ active: query.limit == size }"
          href="#"
          @click.prevent="query.offset = 0; query.limit = size;"
        >{{ size }}</a>
      </div>
    </span>
    <strong>{{ $i18nForDatatable('items / page') }}</strong>
  </label>
</template>
<script>
export default {
  name: 'PageSizeSelect',
  props: {
    query: { type: Object, required: true },
    pageSizeOptions: { type: Array, required: true }
  }
}
</script>
<style>
.-page-size-select {
  display: inline-block;
  width: 65px;
}
</style>
