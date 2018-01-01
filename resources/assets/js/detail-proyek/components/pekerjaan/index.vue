<template lang="html">
  <div class="ui container">
    <div class="ui tall stacked segment">
      <router-link v-if="proyek.status" :to="{ name: 'pekerjaan-create'}" class="ui blue button icon">
        <i class="plus icon"></i>
      </router-link>
      <hr v-if="proyek.status" />
      <table class="ui table">
        <thead>
          <tr>
            <th class="nomor">No</th>
            <th>Pekerjaan</th>
            <th>Harga</th>
            <th>Bobot</th>
            <th>Durasi</th>
            <th>Kode</th>
            <th>Pendahulan</th>
            <th v-if="proyek.status"  class="action">#</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in pekerjaan">
            <td>{{ index+1 }}</td>
            <td>{{ item.nama_pekerjaan }}</td>
            <td>{{ item.harga }}</td>
            <td>{{ item.bobot }}</td>
            <td>{{ item.durasi }}</td>
            <td>{{ item.initial }}</td>
            <td>{{ item.pendahulu }}</td>
            <td v-if="proyek.status" >
              <a class="ui red button icon" v-on:click="hapus(item.id)"><i class="trash icon"></i></a>
            </td>
          </tr>
        </tbody>
      </table>

      <a v-if="proyek.status" class="ui green button icon" v-on:click="lock"><i class="lock icon"></i></a>
    </div>
  </div>
</template>

<script>
export default {
  name: "DetailPekerjaanIndex",
  data(){
    return {
      pekerjaan: [],
      proyek: []
    }
  },
  methods:{
    getData(){
      var that = this
      this.$http.get('/pekerjaan')
        .then(res => {
          Vue.set(that.$data, 'pekerjaan', res.data)
        })
    },
    getProyek(){
      var that = this
      this.$http.get('')
        .then(res => {
          Vue.set(that.$data, 'proyek', res.data)
        })
    },
    lock(){
      let that = this
       this.$http.post('')
        .then(res => {
          that.$swal(
              "Locked!",
              res.data.message,
              "success"
            ).then(() => {
              that.$router.go(-1)
            })
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
          that.$http.delete('/pekerjaan/'+id).then(res => {
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
    this.getProyek()
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
