<template>
<div class="loading" v-if="show">
  <div class="bg-loader"></div>
    <div class="loader"></div>
</div>
</template>
<script>
export default {
  data() {
    return {}
  },
  props: ['show'],
  watch: {
    'show' () {
      document.body.style.overflow = this.show ? 'hidden' : ''
    }
  }
}
</script>
<style lang = 'scss'>
.bg-loader {
  position: fixed;
  top: 0px;
  left: 0px;
  width: 100%;
  height: 100%;
  background: #fff;
  opacity: .5;
  z-index: 999999;
}

.loader {
  border: 14px solid #f3f3f3;
  border-radius: 50%;
  border-top: 14px solid #3498db;
  width: 80px;
  height: 80px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
  position: fixed;
  top: 45%;
  z-index: 9999999;
  left: 50%;
}

.loading {
  position: fixed !important;
  width: 100%;
  height: 100%;
  z-index: 999999;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>