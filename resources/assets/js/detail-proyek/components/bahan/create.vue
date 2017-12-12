<template lang="html">
  <div class="ui container">
    <div class="ui tall stacked segment">
      <form class="ui form" v-on:submit.prevent="simpan">

        <div class="field">
          <label>Bahan</label>
          <select v-model="data.bahan">
            <option v-for="item in bahan" :value="item.id">{{ item.bahan_baku }}</option>
          </select>
        </div>

        <div class="field">
          <label>Jumlah</label>
          <input type="text" v-model="data.jumlah">
        </div>

        <button class="ui green button">Simpan</button>
      </form>
    </div>
  </div>
</template>

<script>
import {base_url} from './../../../config/env'
export default {
  name: 'DetailBahanCreate',
  data(){
    return {
      data: {
        bahan: '',
        jumlah: '',
      },
      bahan: []
    };
  },
  methods:{
    getSelectBahan(){
      var self = this
      this.$http.get(`${base_url}/bahan-baku`)
        .then(res => {
          Vue.set(self.$data, 'bahan', res.data)
        })
    },
    simpan(){
      var self = this
      this.$http.post('/bahan', this.data)
        .then(res => {
          self.$swal(
            'Created!',
            res.data.message,
            'success'
          )
          self.$router.push({ name: 'bahan-index'})
        })
    }
  },
  beforeMount(){
    this.getSelectBahan()
  }
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
