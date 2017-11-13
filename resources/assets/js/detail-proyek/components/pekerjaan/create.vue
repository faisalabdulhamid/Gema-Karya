<template lang="html">
  <div class="ui container">
    <div class="ui tall stacked segment">
      <form class="ui form" v-on:submit.prevent="simpan">
        <div class="field">
          <label>Kode</label>
          <input type="text" v-model="data.initial">
        </div>

        <div class="field">
          <label>Pekerjaan</label>
          <select v-model="data.pekerjaan">
            <option v-for="item in pekerjaan" :value="item.id">{{ item.pekerjaan }}</option>
          </select>
        </div>

        <div class="field">
          <label>Harga</label>
          <input type="text" v-model="data.harga">
        </div>

        <div class="field">
          <label>Durasi</label>
          <input type="text" v-model="data.durasi">
        </div>

        <div class="field">
          <label>Bobot</label>
          <input type="text" v-model="data.bobot">
        </div>

        <div class="field">
          <label>Jumlah Minggu</label>
          <input type="text" v-model="data.jumlah_minggu">
        </div>

        <button class="ui green button">Simpan</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DetailPekerjaanCreate',
  data(){
    return {
      data: {
        initial: '',
        pekerjaan: '',
        harga: '',
        durasi: '',
        bobot: '',
        jumlah_minggu: '',
      },
      pekerjaan: []
    };
  },
  methods:{
    getSelectPekerjaan(){
      var that = this
      axios.get('/pekerjaan')
        .then(res => {
          Vue.set(that.$data, 'pekerjaan', res.data)
        })
        .catch(error => {
          console.log(error)
        })
    },
    simpan(){
      var that = this
      this.$http.post('/pekerjaan', this.data)
        .then(res => {
          swal(
            'Created!',
            res.data.message,
            'success'
          )
          that.$router.push({ name: 'pekerjaan-index'})
        })
        .catch(err => {
          console.log(err);
        })
    }
  },
  created(){
    this.getSelectPekerjaan()
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
