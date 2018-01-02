<template lang="html">
  <div class="ui container">
    <div id="tab" class="ui pointing menu">
      <div class="item active" data-tab="grafik">Grafik</div>
      <div class="item" data-tab="bobot-kegiatan">Bobot Kegiatan</div>
      <div class="item" data-tab="bcws">BCWS</div>
      <div class="item" data-tab="bcwp">BCWP</div>
      <div class="item" data-tab="acwp">ACWP</div>
      <div class="item right" data-tab="tambah" v-show="showTambah">TAMBAH</div>
    </div>
    <!-- GRAFIK -->
    <div class="ui tab tall stacked segment active" data-tab="grafik">
      <h2>GRAFIK</h2>
      <hr>
        <line-chart
          :data="chart"
          :options="options"
          :key="$route.fullPath"
        >
        </line-chart>
    </div>

    <!-- KEGIATAN -->
    <div class="ui tab tall stacked segment" data-tab="bobot-kegiatan">      
      <h2>Bobot Kegiatan</h2>
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
          <tr v-for="item in kegiatan">
            <td>{{ item.initial }}</td>
            <td>{{ item.nama_pekerjaan }}</td>
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
        <tbody>
          <tr v-for="item in bcws">
            <td>{{ item.minggu_ke}}</td>
            <td>{{ item.bobot }}</td>
            <td>{{ item.budget }}</td>
            <td>{{ item.kumulatif }}</td>
          </tr>
        </tbody>
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
        <tbody>
          <tr v-for="item in bcwp">
            <td>{{ item.minggu_ke }}</td>
            <td>{{ item.bcwp_bobot }}</td>
            <td>{{ item.bcwp_budget }}</td>
            <td>{{ item.bcwp_kumulatif }}</td>
          </tr>
        </tbody>
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
            <th>Budget/Minggu</th>
            <th>Kumulatif</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in acwp">
            <td>{{ item.minggu_ke }}</td>
            <td>{{ item.acwp_budget }}</td>
            <td>{{ item.acwp_kumulatif }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Tambah -->
    <div class="ui tab tall stacked segment" data-tab="tambah" v-show="showTambah">
      <form class="ui form" v-on:submit.prevent="simpan">
        <h2>Minggu ke - {{ bcwp.length + 1 }}</h2>
        <hr/>
        <div class="field">
          <label>Total Persenan pada minggu ini</label>
          <input type="text" v-model="data.percent">
        </div>
        <div class="field">
          <label>Total Budget Pada Minggu ini</label>
          <input type="text" v-model="data.budget">
        </div>
        <button class="ui green button">Simpan</button>
      </form>
    </div>
  </div>
</template>

<script>
import LineChart from './chart'
  // import Chart from 'chart.js';
// import { Line } from 'vue-chartjs'
export default {
  // extends: Line,
  name: "DetailEVMIndex",
  data(){
    return {
      kegiatan: [],
      bcws: [],
      bcwp: [],
      acwp: [],
      data:{
        minggu_ke: ''
      },
      chart: '',

      options:{
        responsive: true, 
        maintainAspectRatio: false, 
        elements: {
          line: {
            tension: 0, // disables bezier curves
          }
        },
        title:{
          display:true,
          text:'Grafik BCWS, BCWP & ACWP'
        },
        hover: {
          mode: 'nearest',
          intersect: true
        },
        scales: {
          xAxes: [{
            display: true,
            scaleLabel: {
                display: true,
                labelString: 'Minggu'
            }
          }],
          yAxes: [{
            display: true,
            scaleLabel: {
                display: true,
                labelString: 'Budget'
            }
          }]
        }
      }
    }
  },
  components: {
    'line-chart': function (resolve) {
      setTimeout(function(){
        require(['./chart'], resolve)
      }, 1000)
    }
  },
  computed:{
    showTambah(){
      return this.bcws.length !== this.bcwp.length
    }
  },
  methods:{
    getData(){
      var self = this
      this.$http.get('/evm').then(res => {
        
        Vue.set(self.$data, 'kegiatan', res.data.kegiatan)

        var bcws_kumulatif = 0;
        let bcws = res.data.bcws.map((item, key) => {
          bcws_kumulatif = bcws_kumulatif + item.budget;
          return {
            'minggu_ke': item.minggu_ke,
            'bobot': item.bobot,
            'budget': item.budget,
            'kumulatif': bcws_kumulatif,
          }
        })
        Vue.set(self.$data, 'bcws', bcws)

        var bcwp_kumulatif = 0
        let bcwp = res.data.bcwp.map((item, $key)=>{
          bcwp_kumulatif = bcwp_kumulatif + item.bcwp_budget
          return {
            minggu_ke: item.minggu_ke,
            bcwp_bobot: item.bcwp_bobot,
            bcwp_budget: item.bcwp_budget,
            bcwp_kumulatif: bcwp_kumulatif
          }
        })
        Vue.set(self.$data, 'bcwp', bcwp)

        var acwp_kumulatif = 0
        let acwp = res.data.acwp.map((item, key) => {
          acwp_kumulatif = acwp_kumulatif + item.acwp_budget
          return {
            minggu_ke: item.minggu_ke,
            acwp_budget: item.acwp_budget,
            acwp_kumulatif: acwp_kumulatif,
          }
        })
        Vue.set(self.$data, 'acwp', acwp)
        Vue.set(self.$data, 'chart', res.data.chart)

        this.data.minggu_ke = res.data.bcwp.length + 1
      })
    },
    simpan(){
      let self = this
      self.$http.post('/post-data', this.data)
        .then(res => {
          self.$swal({
            title: "saved!",
            text: res.data.message,
            type: "success",
            timer: 5000
          }).then(() => {
            self.data = {}
            self.getData()
          })
        })
    }
  },
  created(){
    this.getData()
  },
  mounted (){
    // this.getData()
    $('#tab .item').tab();
  },
  ready(){
    this.getData()
    
  }
}
</script>

<style lang="scss" scoped>
  .ui.menu .active.item{
    background-color: #4888C8;
  }
</style>
