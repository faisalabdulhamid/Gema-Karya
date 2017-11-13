<template>
  <div class="ui container">
    <h2 class="ui center aligned icon header">
      <i class="circular suitcase icon"></i>
      Proyek
    </h2>

    <div class="ui tall stacked segment">
      <router-link :to="{ name: 'create'}" class="ui green button icon"><i class="plus icon"></i></router-link>
      <hr/>
      <table class="ui table">
        <thead>
          <tr>
            <th class="nomor">No</th>
            <th>Proyek</th>
            <th>Tanggal Kontrak</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th class="actions">#</th>
          </tr>
        </thead>
        <tbody></tbody>
        <tbody>
          <tr v-for="(item, index) in proyek">
            <td>{{ index+1 }}</td>
            <td>{{ item.nama }}</td>
            <td>{{ item.tanggal_kontrak }}</td>
            <td>{{ item.tanggal_mulai }}</td>
            <td>{{ item.tanggal_selesai }}</td>
            <td>
              <div class="ui small icon buttons">
                <a class="ui yellow button icon" :href="item.url_show">
                  <i class="zoom icon"></i>
                </a>
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
  name: "ProyekIndex",
  data(){
    return {
      proyek: []
    }
  },
  methods:{
    getProyek(){
      var that = this
      this.$http.get('').then(res => {
        Vue.set(that.$data, 'proyek', res.data)
      }).catch(err => {
        console.log(err)
      })
    },
    hapus(id){
      swal({
        title: "Are you sure?",
        text: "Are you sure that you want to leave this page?",
        icon: "warning",
        dangerMode: true,
      })
      .then(willDelete => {
        if (willDelete) {
          var that = this
          that.$http.delete('/'+id).then(res => {
            swal(
              "Deleted!",
              res.data.message,
              "success"
            ).then(() => {
              that.$router.go({name: 'index'})
            })
            setTimeout(function(){
              that.$router.go({name: 'index'})
            }, 3000)
          }).catch(err => {
            console.log(err)
          })
        }
      });
    }
  },
  created(){
    this.getProyek()
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
