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
      var that = this
      axios.get('/bahan-baku')
        .then(res => {
          Vue.set(that.$data, 'bahan', res.data)
        })
        .catch(error => {
          console.log(error)
        })
    },
    simpan(){
      var that = this
      this.$http.post('/bahan', this.data)
        .then(res => {
          swal(
            'Created!',
            res.data.message,
            'success'
          )
          that.$router.push({ name: 'bahan-index'})
        })
        .catch(err => {
          console.log(err);
        })
    }
  },
  created(){
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
