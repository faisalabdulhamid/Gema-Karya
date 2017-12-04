<template lang="html">
  <div class="ui container">
    <div class="ui tall stacked segment">
      <form class="ui form" v-on:submit.prevent="simpan">

        <div class="field">
          <label>Nama Pegawai</label>
          <select v-model="data.pegawai">
            <option v-for="item in pegawai" :value="item.id">{{ item.nama }}</option>
          </select>
        </div>

        <button class="ui green button">Simpan</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DetailPegawaiCreate',
  data(){
    return {
      data: {
        pegawai: '',
      },
      pegawai: []
    };
  },
  methods:{
    getSelectPegawai(){
      var that = this
      axios.get('/pegawai')
        .then(res => {
          Vue.set(that.$data, 'pegawai', res.data)
        })
    },
    simpan(){
      var that = this
      this.$http.post('/pegawai', this.data)
        .then(res => {
          this.$swal(
            'Created!',
            res.data.message,
            'success'
          )
          that.$router.push({ name: 'pegawai-index'})
        })
    }
  },
  created(){
    this.getSelectPegawai()
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
