<template lang="html">
  <div class="ui container">
    <div class="ui tall stacked segment">
      <form class="ui form" v-on:submit.prevent="simpan">
        <div class="field">
          <label>Kode</label>
          <input type="text" v-model="data.kode">
        </div>

        <div class="field">
          <label>Resiko</label>
          <select v-model="data.resiko">
            <option v-for="item in resiko" :value="item.id">{{ item.resiko }}</option>
          </select>
        </div>

        <div class="field">
          <label>Nilai Dampak</label>
          <select type="text" v-model="data.nilai_dampak">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
        </div>

        <div class="field">
          <label>Dampak</label>
          <textarea rows="2" v-model="data.dampak"></textarea>
        </div>

        <div class="field">
          <label>Nilai Kemungkinan</label>
          <select type="text" v-model="data.nilai_kemungkinan">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
        </div>

        <div class="field">
          <label>Kemungkinan</label>
          <textarea rows="2" v-model="data.kemungkinan"></textarea>
        </div>

        <div class="field">
          <label>Level</label>
          <input type="text" v-model="data.level">
        </div>

        <div class="field">
          <label>Mitigasi</label>
          <textarea rows="2" v-model="data.mitigasi"></textarea>
        </div>

        <button class="ui green button">Simpan</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
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
    getSelectResiko(){
      var that = this
      axios.get('/resiko')
        .then(res => {
          Vue.set(that.$data, 'resiko', res.data)
        })
    },
    simpan(){
      var that = this
      this.$http.post('/resiko', this.data)
        .then(res => {
          that.$swal(
            'Created!',
            res.data.message,
            'success'
          )
          that.$router.push({ name: 'resiko-index'})
        })
    }
  },
  created(){
    this.getSelectResiko()
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
