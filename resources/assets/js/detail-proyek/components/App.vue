<template>
  <div id="root">

    <template>
      <div class="ui container">
        <router-view :key="$route.fullPath"></router-view>
      </div>
    </template>

    <div class="ui right demo vertical inverted labeled icon sidebar menu visible">
      <sidebar-direktur v-show="user.status == 'direktur'"></sidebar-direktur>
      <sidebar-teknis v-show="user.status == 'teknis'"></sidebar-teknis>
    </div>

  </div>
</template>

<script>
export default {
  name: 'AppDetail',
  components: {
    'sidebar-direktur': require('./sidebar-direktur'),
    'sidebar-teknis': require('./sidebar-teknis'),
  },
  computed:{
    user(){
      let user = localStorage.getItem('user')
      return JSON.parse(user)
    }
  }
}
</script>

<style lang="scss" scoped>
  .container{
    min-height:100vh;
  }
</style>
