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
  name: "Edit",
  props: ['id'],
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
      let self = this
      this.$http.put('/'+id[2], this.data)
        .then(res => {
          this.$swal(
            'Updated!',
            res.data.message,
            'success'
          )
          self.$router.push({ name: 'index'})
        })
    },
    getData(){
      let self = this
      this.$http.get('/'+id[2]).then(res => {
        Vue.set(self.$data, 'data', res.data)
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
