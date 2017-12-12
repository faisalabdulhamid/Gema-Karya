<template lang="html">
  <div class="ui container">
    <h2 class="ui center aligned icon header">
      <i class="circular suitcase icon"></i>
      Bahan Baku
    </h2>

    <div class="ui tall stacked segment">
      <form class="ui form" v-on:submit.prevent="simpan">
        <div class="field">
          <label>Bahan Baku</label>
          <input v-model="data.bahan_baku" />
        </div>
        <div class="field">
          <label>Satuan</label>
          <input v-model="data.satuan" />
        </div>
        <div class="field">
          <label>Harga</label>
          <input v-model="data.harga" />
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
        id: '',
        bahan_baku: '',
        satuan: '',
        harga: '',
      }
    }
  },
  methods:{
    simpan(){
      let self = this
      this.$http.put('/'+this.id, this.data)
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
      this.$http.get('/'+this.id)
        .then(res => {
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
