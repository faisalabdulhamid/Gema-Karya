<template lang="html">
  <div class="ui container">
    <div id="tab" class="ui pointing menu">
      <div class="item active" data-tab="grafik">Grafik</div>
      <div class="item" data-tab="bobot-kegiatan">Bobot Kegiatan</div>
      <div class="item" data-tab="bcws">BCWS</div>
      <div class="item" data-tab="bcwp">BCWP</div>
      <div class="item" data-tab="acwp">ACWP</div>
      <div class="item right" data-tab="tambah">TAMBAH</div>
    </div>
    <!-- GRAFIK -->
    <div class="ui tab tall stacked segment active" data-tab="grafik">
      <h2>GRAFIK</h2>
      <hr>
      HHHHA
    </div>

    <!-- KEGIATAN -->
    <div class="ui tab tall stacked segment" data-tab="bobot-kegiatan">      
      <h2>BOBOT KEGIATAN</h2>
      <hr>
      <table class="ui celled table">
        <thead>
          <tr>
            <th>Kode Kegiatan</th>
            <th>Kegiatan</th>
            <th>Harga Pekerjaan</th>
            <th>Bobot</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in data.kegiatan">
            <td>{{ item.kode }}</td>
            <td>{{ item.kegiatan }}</td>
            <td>{{ item.harga }}</td>
            <td>{{ item.bobot }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- BCWS  -->
    <div class="ui tab tall stacked segment" data-tab="bcws">
      <h2>Budgetede Cost of Work Schedule (BCWS)</h2>
      <hr>
      <table class="ui celled table">
        <thead>
          <tr>
            <th>Minggu Ke-</th>
            <th>Bobot/Minggu</th>
            <th>Budget/Minggu</th>
            <th>Kumulatif</th>
          </tr>
        </thead>
      </table>
    </div>

    <!-- BCWP -->
    <div class="ui tab tall stacked segment" data-tab="bcwp">
      <h2>Budgetede Cost of Work Performed (BCWP)</h2>
      <hr>
      <table class="ui celled table">
        <thead>
          <tr>
            <th>Minggu Ke-</th>
            <th>Bobot/Minggu</th>
            <th>Budget/Minggu</th>
            <th>Kumulatif</th>
          </tr>
        </thead>
      </table>
    </div>

    <!-- ACWP -->
    <div class="ui tab tall stacked segment" data-tab="acwp">
      <h2>Actual Cost of Work Performed (ACWP)</h2>
      <hr>
      <table class="ui celled table">
        <thead>
          <tr>
            <th>Minggu Ke-</th>
            <th>Bobot/Minggu</th>
            <th>Budget/Minggu</th>
            <th>Kumulatif</th>
          </tr>
        </thead>
      </table>
    </div>

    <!-- Tambah -->
    <div class="ui tab tall stacked segment" data-tab="acwp">
      Tambah
    </div>
  </div>
</template>

<script>
export default {
  name: "DetailEVMIndex",
  data(){
    return {
      data:{
        kegiatan: []
      }
    }
  },
  methods:{
    getData(){
      var self = this
      this.$http.get('/evm').then(res => {
        Vue.set(self.$data, 'data', res.data)
      })
    }
  },
  created(){
    this.getData()
  },
  mounted (){
    $('#tab .item').tab();
  }
}
</script>

<style lang="scss" scoped>
  .ui.menu .active.item{
    background-color: #4888C8;
  }
</style>
