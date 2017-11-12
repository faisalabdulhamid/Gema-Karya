<template lang="html">
  <div class="ui container">
    <h2 class="ui center aligned icon header">
      <i class="circular suitcase icon"></i>
      Proyek
    </h2>

    <div class="ui tall stacked segment">
      <form class="ui form" v-on:submit.prevent="simpan">
        <div class="field">
          <label>Nama Proyek</label>
          <input v-model="data.nama"/>
        </div>
        <div class="field">
          <label>Nilai Kontrak</label>
          <input v-model="data.nilai_kontrak"/>
        </div>
        <div class="field">
          <label>Tanggal Kontrak</label>
          <input v-model="data.tanggal_kontrak"/>
        </div>
        <div class="field">
          <label>Tanggal Mulai</label>
          <input v-model="data.tanggal_mulai"/>
        </div>
        <div class="field">
          <label>Tanggal Selesai</label>
          <input v-model="data.tanggal_selesai"/>
        </div>
        <div class="field">
          <label>Deskripsi</label>
          <textarea rows="2" v-model="data.deskripsi"></textarea>
        </div>
        <button class="ui green button">Simpan</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: "EditProyek",
  data(){
    return {
      data:{
        nama: '',
        nilai_kontrak: '',
        tanggal_kontrak: '',
        tanggal_mulai: '',
        tanggal_selesai: '',
        deskripsi: ''
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
          swal(
            'Updated!',
            res.data.message,
            'success'
          )
          that.$router.push({ name: 'index'})
        })
        .catch(err => {
          console.log(err)
        })
    },
    getData(){
      var url = window.location.hash
      var id = url.split('/')

      var that = this
      this.$http.get('/'+id[2]).then(res => {
        Vue.set(that.$data, 'data', res.data)
      }).catch(err => {
        console.log(err);
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
