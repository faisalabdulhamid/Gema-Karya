<template lang="html">
  <div class="ui container">
    <div class="ui tall stacked segment">
      DIAGRAM
    </div>
  </div>
</template>

<script>
export default {
  name: "DetailPegawaiIndex",
  data(){
    return {
      pegawai: []
    }
  },
  methods:{
    getData(){
      var that = this
      this.$http.get('/pegawai')
        .then(res => {
          Vue.set(that.$data, 'pegawai', res.data)
        })
    },
    hapus(id){
      this.$swal({
        title: "Are you sure?",
        text: "Are you sure that you want to leave this page?",
        icon: "warning",
        dangerMode: true,
      })
      .then(willDelete => {
        if (willDelete) {
          var that = this
          that.$http.delete('/pegawai/'+id).then(res => {
            that.$swal(
              "Deleted!",
              res.data.message,
              "success"
            ).then(() => {
              that.getData()
            })
            setTimeout(function(){
              that.getData()
            }, 3000)
          })

        }
      });
    }
  },
  created(){
    this.getData()
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

  .nomor{
    width: 50px;
  }
  .action{
    width: 50px;
  }
}
</style>
