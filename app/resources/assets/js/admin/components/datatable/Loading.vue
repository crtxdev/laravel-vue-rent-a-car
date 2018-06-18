<template lang="html">
<div>
  <div class="datatable-loading-wrapper">
    <div class="datatable-loading-inner">
      <div class="loading-whirlpool-container">
      	<div class="loading-whirlpool"></div>
      </div>
      <div class="datatable-loading-text mt-4">
        {{ $t('loading') }}...
      </div>
    </div>
  </div>
</div>
</template>

<script>
export default {
  name: 'Loading'
}
</script>

<style lang="scss">
.datatable-loading-wrapper {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 9;
  display: table;
  background-color: rgba(white, .25);
  text-align: center;
  .datatable-loading-inner {
    display: table-cell;
    width: 100%;
    height: 100%;
    vertical-align: middle;
    .datatable-loading-text {
      font-size: 2rem;
    }
  }
}
</style>
