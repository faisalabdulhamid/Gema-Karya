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
  name: "Edit",
  props: ['id'],
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
      let self = this
      this.$http.put('/'+this.id, this.data)
        .then(res => {
          self.$swal(
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
