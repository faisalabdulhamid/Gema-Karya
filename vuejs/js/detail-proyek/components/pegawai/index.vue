<template lang="html">
  <div class="ui container">
    <div class="ui tall stacked segment">
      <router-link :to="{ name: 'pegawai-create'}" class="ui blue button icon">
        <i class="plus icon"></i>
      </router-link>
      <hr/>
      <table class="ui table">
        <thead>
          <tr>
            <th class="nomor">No</th>
            <th>Pegawai</th>
            <th class="action">#</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in pegawai">
            <td>{{ index+1 }}</td>
            <td>{{ item.pegawai }}</td>
            <td>
              <a class="ui red button icon" v-on:click="hapus(item.id)"><i class="trash icon"></i></a>
            </td>
          </tr>
        </tbody>
      </table>
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
