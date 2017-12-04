<template>
  <div class="ui container">
    <h4 class="ui horizontal divider header">
      <i class="tag icon"></i>
      {{ proyek.nama }}
    </h4>

    <div class="ui tall stacked segment">
      <table class="ui table">
        <tbody>
          <tr>
            <td>Nama Proyek</td>
            <td>{{ proyek.nama  }}</td>
          </tr>
          <tr>
            <td>Nilai Kontrak</td>
            <td>{{ proyek.nilai_kontrak }}</td>
          </tr>
          <tr>
            <td>Tanggal Kontrak</td>
            <td>{{ proyek.tanggal_kontrak }}</td>
          </tr>
          <tr>
            <td>Tanggal Mulai</td>
            <td>{{ proyek.tanggal_mulai }}</td>
          </tr>
          <tr>
            <td>Tanggal Selesai</td>
            <td>{{ proyek.tanggal_selesai }}</td>
          </tr>
          <tr>
            <td>Deskripsi</td>
            <td>{{ proyek.deskripsi }}</td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
</template>

<script>
import { mapActions, mapState, mapGetters } from 'vuex'

export default {
  name: "IndexDetailProyek",
  data(){
    return {
      proyek: {}
    };
  },
  methods: mapActions({
    getProyek(){

      var that = this
      this.$http.get('').then(res => {
        Vue.set(that.$data, 'proyek', res.data)
      })
    }
  }),
  created(){
    this.getProyek()
  },
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
  }
</style>
