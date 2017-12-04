<template>
  <div class="ui container">
    <h2 class="ui center aligned icon header">
      <i class="circular suitcase icon"></i>
      Pekerjaan
    </h2>

    <div class="ui tall stacked segment">
      <router-link :to="{ name: 'create'}" class="ui green button icon"><i class="plus icon"></i></router-link>
      <hr/>
      <table class="ui table">
        <thead>
          <tr>
            <th class="nomor">No</th>
            <th>Pekerjaan</th>
            <th class="actions">#</th>
          </tr>
        </thead>
        <tbody></tbody>
        <tbody>
          <tr v-for="(item, index) in pekerjaan">
            <td>{{ index+1 }}</td>
            <td>{{ item.pekerjaan }}</td>
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
  name: "PekerjaanIndex",
  data(){
    return {
      pekerjaan: []
    }
  },
  methods:{
    getPekerjaan(){
      var that = this
      this.$http.get('').then(res => {
        Vue.set(that.$data, 'pekerjaan', res.data)
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
            that.$swal(
              "Deleted!",
              res.data.message,
              "success"
            ).then(() => {
              that.getPekerjaan()
            })
            setTimeout(function(){
              that.getPekerjaan()
            }, 3000)
          }).catch(err => {
            console.log(err)
          })

        }
      });
    }
  },
  created(){
    this.getPekerjaan()
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
