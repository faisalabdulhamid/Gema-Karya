<template>
  <div class="ui container">
    <h2 class="ui center aligned icon header">
      <i class="circular suitcase icon"></i>
      Pegawai
    </h2>

    <div class="ui tall stacked segment">
      <router-link :to="{ name: 'create'}" class="ui green button icon"><i class="plus icon"></i></router-link>
      <hr/>
      <table class="ui table">
        <thead>
          <tr>
            <th class="nomor">No</th>
            <th>Nama</th>
            <th class="actions">#</th>
          </tr>
        </thead>
        <tbody></tbody>
        <tbody>
          <tr v-for="(item, index) in pegawai">
            <td>{{ index+1 }}</td>
            <td>{{ item.nama }}</td>
            <td>
              <div class="ui small icon buttons">
                <router-link :to="{ name: 'edit', params: {'id':item.id} }" class="ui blue button icon">
                  <i class="edit icon"></i>
                </router-link>
                <a class="ui red button icon" v-on:click="hapus(item.id)">
                  <i class="trash icon"></i>
                </a>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
</template>

<script>
export default {
  name: "PegawaiIndex",
  data(){
    return {
      pegawai: []
    }
  },
  methods:{
    getData(){
      var that = this
      this.$http.get('').then(res => {
        Vue.set(that.$data, 'pegawai', res.data)
      }).catch(err => {
        console.log(err)
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
          that.$http.delete('/'+id).then(res => {
            this.$swal(
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
    .segment{
      margin: 30px;
    }
  }
  .actions{
    width: 100px
  }
  .nomor{
    width: 50px
  }
</style>
