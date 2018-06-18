<template>
  <div class="main-layout">
    <Navbar />
    <div class="container-fluid page-wrapper">
      <Sidebar />
      <div class="page-content mt-4">
        <Child />
      </div>
    </div>
  </div>
</template>

<script>
import Navbar from '~/admin/components/Navbar'
import Sidebar from '~/admin/components/Sidebar'

export default {
  name: 'MainLayout',

  components: {
    Navbar,
    Sidebar
  }
}
</script>
