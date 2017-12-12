<template lang="html">
  <div class="ui container">
    <h2 class="ui center aligned icon header">
      <i class="circular suitcase icon"></i>
      Pekerjaan
    </h2>

    <div class="ui tall stacked segment">
      <form class="ui form" v-on:submit.prevent="simpan">
        <div class="field">
          <label>Pekerjaan</label>
          <textarea name="pekerjaan" rows="2" v-model="data.pekerjaan"></textarea>
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
        pekerjaan: ''
      }
    }
  },
  methods:{
    simpan(){
      let self = this
      this.$http.post('', this.data)
        .then(res => {
          this.$swal(
            'Created!',
            res.data.message,
            'success'
          )
          self.$router.push({ name: 'index'})
        })
    }
  },
  created(){

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
