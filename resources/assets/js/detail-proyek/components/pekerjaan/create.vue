<template lang="html">
  <div class="ui container">
    <div class="ui tall stacked segment">
      <form class="ui form" v-on:submit.prevent="simpan">
        <div class="field">
          <label>Initial</label>
          <input type="text" v-model="data.initial">
        </div>

        <div class="field">
          <label>Pekerjaan</label>
          <select v-model="data.pekerjaan">
            <option v-for="item in pekerjaan" :value="item.id">{{ item.pekerjaan }}</option>
          </select>
        </div>

        <div class="field">
          <label>Harga</label>
          <input type="text" v-model="data.harga">
        </div>

        <div class="field">
          <label>Durasi</label>
          <input type="text" v-model="data.durasi">
        </div>

        <div class="field" v-for="(pek, idx) in data.pekerjaan_sebelumnya">
          <label>Pekerjaan Sebelumnya {{ idx+1 }}</label>
          <div class="ui action input">
            <select v-model="data.pekerjaan_sebelumnya[idx]">
              <option v-for="item in pekerjaan_sebelumnya" :value="item.pekerjaan_id">{{ item.initial+' - '+item.pekerjaan.pekerjaan }}</option>
            </select>
            <a class="mini ui blue button" v-on:click="addSebelumnya"><i class="plus icon"></i></a>
            <a class="mini ui red button" v-on:click="removeSebelumnya(idx)"><i class="trash icon"></i></a>
          </div>
        </div>

        <button class="ui green button">Simpan</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DetailPekerjaanCreate',
  data(){
    return {
      data: {
        initial: '',
        pekerjaan: '',
        harga: '',
        durasi: '',
        pekerjaan_sebelumnya: [
          0
        ]
      },
      pekerjaan: [],
      pekerjaan_sebelumnya: []
    };
  },
  methods:{
    getSelectPekerjaan(){
      var that = this
      axios.get('/pekerjaan')
        .then(res => {
          Vue.set(that.$data, 'pekerjaan', res.data)
        })
    },
    getSelectPekerjaanSebelum(){
      var that = this
      this.$http.get('/select/pekerjaan-sebelumnya')
        .then(res => {
          Vue.set(that.$data, 'pekerjaan_sebelumnya', res.data)
        })
    },
    addSebelumnya(){
      this.data.pekerjaan_sebelumnya.push(0)
    },
    removeSebelumnya(idx){
      if(this.data.pekerjaan_sebelumnya.length > 1){
        this.data.pekerjaan_sebelumnya.splice(idx, 1)
      }
    },
    simpan(){
      var that = this
      this.$http.post('/pekerjaan', this.data)
        .then(res => {
          that.$swal(
            'Created!',
            res.data.message,
            'success'
          )
          that.$router.push({ name: 'pekerjaan-index'})
        })
    }
  },
  created(){
    this.getSelectPekerjaan()
    this.getSelectPekerjaanSebelum()
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
}
</style>
