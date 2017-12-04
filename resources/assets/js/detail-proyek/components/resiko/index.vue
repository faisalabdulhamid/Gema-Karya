<template lang="html">
  <div class="ui container">
    <div class="ui tall stacked segment">
      <router-link :to="{ name: 'resiko-create'}" class="ui green button icon">
        <i class="plus icon"></i>
      </router-link>
      <hr/>
      <table class="ui table">
        <thead>
          <tr>
            <th class="nomor">Kode</th>
            <th>Resiko</th>
            <th class="nomor">Tingkat</th>
            <th class="action">#</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in resiko">
            <td>{{ item.kode }}</td>
            <td>{{ item.resiko }}</td>
            <td>{{ item.nilai_dampak * item.nilai_kemungkinan }}</td>
            <td>
              <div class="ui small icon buttons">
                <router-link :to="{ name: 'resiko-show', params: {id: item.id} }" class="ui blue button icon">
                  <i class="zoom icon"></i>
                </router-link>
                <a class="ui red button icon" v-on:click="hapus(item.id)"><i class="trash icon"></i></a>
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
  name: "DetailResikoIndex",
  data(){
    return {
      resiko: []
    }
  },
  methods:{
    getData(){
      var that = this
      this.$http.get('/resiko')
        .then(res => {
          Vue.set(that.$data, 'resiko', res.data)
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
          that.$http.delete('/resiko/'+id).then(res => {
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
    width: 100px;
  }
}
</style>
