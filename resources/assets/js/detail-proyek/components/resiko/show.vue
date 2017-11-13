<template lang="html">
  <div class="ui container">
    <div class="ui tall stacked segment">
      <table class="ui table">
        <tbody>
          <tr>
            <td class="kode">Kode</td>
            <td>{{ data.kode }}</td>
          </tr>
          <tr>
            <td>Tingkat</td>
            <td>{{ data.nilai_dampak * data.nilai_kemungkinan }}</td>
          </tr>
          <tr>
            <td>Resiko</td>
            <td>{{ data.resiko }}</td>
          </tr>
          <tr>
            <td>Nilai Dampak</td>
            <td>{{ data.nilai_dampak }}</td>
          </tr>
          <tr>
            <td>Dampak</td>
            <td>{{ data.dampak }}</td>
          </tr>
          <tr>
            <td>Nilai Kemungkinan</td>
            <td>{{ data.nilai_kemungkinan }}</td>
          </tr>
          <tr>
            <td>Kemungkinan</td>
            <td>{{ data.kemungkinan }}</td>
          </tr>
          <tr>
            <td>Level</td>
            <td>{{ data.level }}</td>
          </tr>
          <tr>
            <td>Mitigasi</td>
            <td>{{ data.mitigasi }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  props: ['id'],
  name: 'DetailResikoCreate',
  data(){
    return {
      data: {
        kode: '',
        resiko: '',
        nilai_dampak: '',
        dampak: '',
        nilai_kemungkinan: '',
        kemungkinan: '',
        level: '',
        mitigasi: '',
      },
      resiko: []
    };
  },
  methods:{
    lihat(){
      var that = this
      this.$http.get('/resiko/'+this.id)
        .then(res => {
          Vue.set(that.$data, 'data', res.data)
        })
        .catch(err => {
          console.log(err);
        })
    }
  },
  created(){
    this.lihat()
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
  .kode{
    width: 200px
  }
}
</style>
