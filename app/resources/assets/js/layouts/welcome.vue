<template>
  <div class="welcome-layout d-flex align-items-center justify-content-center m-0 bg-white">
    <div class="welcome-layout-bg" :style="layoutStyle"></div>
    <div class="welcome-layout-content-wrapper">
      <div class="welcome-layout-content">
        <child/>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'WelcomeLayout',
  computed: {
    layoutStyle(){
      return {
        'background-image': `url('${window.config.images.welcome}')`
      }
    }
  }
}
</script>

<style lang="scss">
.welcome-layout {
  color: #fff;
  height: 100vh;
  font-weight: 100;
  position: relative;

  .welcome-layout-bg {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    z-index: 1;
    &::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, .35);
    }
  }

  .welcome-layout-content-wrapper {
    position: absolute;
    z-index: 2;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
  }

  .welcome-layout-content {
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .links > a {
    color: #fff;
    padding: 0 25px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: .1rem;
    text-decoration: none;
    text-transform: uppercase;
  }
}
</style>
