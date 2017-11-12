<template>
  <div class="ui container">
    <h4 class="ui horizontal divider header">
      <i class="tag icon"></i>
      {{ proyek.nama }}
    </h4>

    <div class="ui tall stacked segment">
      <div class="ui secondary pointing menu">
        <a class="item active" data-tab="tab-evm">
          EVM
        </a>
        <a class="item" data-tab="tab-cpm">
          CPM
        </a>
        <a class="item" data-tab="tab-resiko">
          Resiko
        </a>
      </div>
      <div class="ui segment tab active" data-tab="tab-evm">
        <p>
          EVM
        </p>
      </div>
      <div class="ui segment tab" data-tab="tab-cpm">
        <p>
          CPM
        </p>
      </div>
    </div>

  </div>
</template>

<script>
import { mapActions, mapState, mapGetters } from 'vuex'

export default {
  name: "IndexDetailProyek",
  data(){
    return {
      proyek: {}
    };
  },
  methods: mapActions({
    getProyek(){

      var that = this
      this.$http.get('').then(res => {
        Vue.set(that.$data, 'proyek', res.data)
      }).catch(err => {
        console.log(err.response);
      })
    }
  }),
  created(){
    this.getProyek()
  },
}
</script>

<style lang="scss" scoped>
  .container{
    min-height:100vh;
    .header{
      margin: 30px;
    }
    .segment{
      margin: 30px;
    }
  }
</style>
