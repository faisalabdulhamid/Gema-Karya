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
  name: "Index",
  data(){
    return {
      pekerjaan: []
    }
  },
  methods:{
    getData(){
      let self = this
      this.$http.get('').then(res => {
        Vue.set(self.$data, 'pekerjaan', res.data)
      }).catch(err => {
        console.log(err)
      })
    },
    hapus(id){
      this.$swal({
        title: "Are you sure?",
        text: "Are you sure that you want to leave this page?",
        type: "warning",
        showCancelButton: true,
      })
      .then((result) => {
        if (result.value) {
          let self = this
          self.$http.delete('/'+id)
          .then(res => {
            this.$swal({
              title: "Deleted!",
              text: res.data.message,
              type: "success",
              timer: 5000
            }).then(() => {
              self.getData()
            })
          })
        }
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
  .actions{
    width: 100px
  }
  .nomor{
    width: 50px
  }
</style>
