<template lang="html">
  <div class="ui container">
    <div class="ui tall stacked segment">
      <router-link :to="{ name: 'bahan-create'}" class="ui blue button icon">
        <i class="plus icon"></i>
      </router-link>
      <hr/>
      <table class="ui table">
        <thead>
          <tr>
            <th class="nomor">No</th>
            <th>Bahan</th>
            <th>Jumlah</th>
            <th>Satuan</th>
            <th>Harga</th>
            <th>Total</th>
            <th class="action">#</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in bahan">
            <td>{{ index+1 }}</td>
            <td>{{ item.bahan.bahan_baku }}</td>
            <td>{{ item.jumlah }}</td>
            <td>{{ item.bahan.satuan }}</td>
            <td class="text-right">Rp.{{ item.bahan.harga }}</td>
            <td class="text-right">Rp.{{ item.jumlah * item.bahan.harga }}</td>
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
  name: "DetailBahanIndex",
  data(){
    return {
      bahan: []
    }
  },
  methods:{
    getData(){
      let self = this
      this.$http.get('/bahan')
        .then(res => {
          Vue.set(self.$data, 'bahan', res.data)
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
          self.$http.delete('/bahan/'+id)
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

  .text-right{
    text-align: right;
  }
}
</style>
