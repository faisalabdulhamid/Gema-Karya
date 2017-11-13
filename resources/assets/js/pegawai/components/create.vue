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
          <input v-model="data.name"/>
        </div>
        <button class="ui green button">Simpan</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: "CreatePegawai",
  data(){
    return {
      data:{
        name: '',
      }
    }
  },
  methods:{
    simpan(){
      var that = this
      this.$http.post('/', this.data)
        .then(res => {
          swal(
            'Created!',
            res.data.message,
            'success'
          )
          that.$router.push({ name: 'index'})
        })
        .catch(err => {
          console.log(err)
        })
    }
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
