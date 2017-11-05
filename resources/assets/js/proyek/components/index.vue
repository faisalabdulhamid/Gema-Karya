<template>
  <div class="ui container">
    <h4 class="ui horizontal divider header">
      <i class="bar chart icon"></i>
      Proyek
    </h4>
    <button class="ui button icon"><i class="plus icon"></i></button>
    <hr/>
    <table class="ui table">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Nilai Kontrak</th>
          <th>Tanggal Kontrak</th>
          <th>Tanggal Mulai</th>
          <th>Tanggal Selesai</th>
          <th>#</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in proyek">
          <td>{{item.nama}}</td>
          <td>{{item.nilai_kontrak}}</td>
          <td>{{item.tanggal_kontrak}}</td>
          <td>{{item.tanggal_mulai}}</td>
          <td>{{item.tanggal_selesai}}</td>
          <td>
            <div class="ui icon buttons">
              <button class="ui button ">
                <i class="zoom icon"></i>
              </button>
              <button class="ui button ">
                <i class="edit icon"></i>
              </button>
              </button>
              <button class="ui button ">
                <i class="ban icon"></i>
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

  </div>
</template>

<script>
export default {
  name: "IndexProyek",
  data(){
    return {
      proyek: []
    };
  },
  methods: {
    getProyek(){
      var that = this
      axios.get('proyek').then(res => {
        Vue.set(that.$data, 'proyek', res.data)
      }).catch(err => {
        console.log(err.response);
      })
    }
  },
  created(){
    this.getProyek()
  },
}
</script>

<style lang="scss" scoped>
  .container{
    min-height:100vh;
  }
</style>
