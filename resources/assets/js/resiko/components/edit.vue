<template lang="html">
  <div class="ui container">
    <h2 class="ui center aligned icon header">
      <i class="circular suitcase icon"></i>
      Resiko
    </h2>

    <div class="ui tall stacked segment">
      <form class="ui form" v-on:submit.prevent="simpan">
        <div class="field">
          <label>Resiko</label>
          <textarea rows="2" v-model="data.resiko"></textarea>
        </div>
        <button class="ui green button">Simpan</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: "EditResiko",
  data(){
    return {
      data:{
        id: '',
        resiko: ''
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
      this.$http.get('/'+id[2])
        .then(res => {
          Vue.set(that.$data, 'data', res.data)
        })
        .catch(err => {
          console.log(err)
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
