<template lang="html">
  <div class="ui container">
    <h2 class="ui center aligned icon header">
      <i class="circular suitcase icon"></i>
      Pegawai
    </h2>

    <div class="ui tall stacked segment">
      <form class="ui form" v-on:submit.prevent="simpan">
        <div class="field">
          <label>Nama Pegawai</label>
          <input v-model="data.nama"/>
        </div>
        <button class="ui green button">Simpan</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: "EditPegawai",
  data(){
    return {
      data:{
        nama: '',
      }
    }
  },
  methods:{
    simpan(){
      var url = window.location.hash
      var id = url.split('/')

      var that = this
      this.$http.put('/'+id[2], this.data)
        .then(res => {
          this.$swal(
            'Updated!',
            res.data.message,
            'success'
          )
          that.$router.push({ name: 'index'})
        })
    },
    getData(){
      var url = window.location.hash
      var id = url.split('/')

      var that = this
      this.$http.get('/'+id[2]).then(res => {
        Vue.set(that.$data, 'data', res.data)
      })
    }
  },
  beforeMount(){
    this.getData()
  }
}
</script>

<style lang="scss" scoped>
.container{
  min-height:100vh;
  .segment{
    margin: 30px;
  }
}
</style>
