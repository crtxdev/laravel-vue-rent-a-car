<template lang="html">
<div>
  <h1>{{ $t('users') }}</h1>
  <div>
    <UsersWrapper />
  </div>
</div>
</template>

<script>

import UsersWrapper from '~/admin/components/users/UsersWrapper'

export default {

  components: {
    UsersWrapper
  },

  metaInfo () {
    return { title: this.$t('users') }
  },

  data(){
    return {

    }
  }

}

</script>

<style lang="css">
</style>
