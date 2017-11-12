<template>
  <div id="root">

    <template>
      <div class="ui container">
        <router-view></router-view>
      </div>
    </template>

  </div>
</template>

<script>
export default {
}
</script>

<style lang="scss" scoped>
  .container{
    min-height:100vh;
  }
</style>
