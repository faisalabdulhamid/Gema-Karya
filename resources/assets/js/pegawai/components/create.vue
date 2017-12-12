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
  name: "Create",
  data(){
    return {
      data:{
        nama: '',
      }
    }
  },
  methods:{
    simpan(){
      let self = this
      this.$http.post('/', this.data)
        .then(res => {
          this.$swal(
            'Created!',
            res.data.message,
            'success'
          )
          self.$router.push({ name: 'index'})
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
