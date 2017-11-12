<template>
  <div>
    <div class="ui small modal" id="form-modal">
      <i class="close icon"></i>
      <div class="header">
        Modal Title
      </div>
      <div class="form content">
        <form class="ui mini form" id="form">

          <div class="field">
            <label>Nama Proyek</label>
            <input name="nama_proyek" type="text">
          </div>

          <div class="field">
            <label>Pemilik</label>
            <input name="pemilik" type="text">
          </div>

          <div class="field">
            <label>Nilai Kontrak</label>
            <input name="nilai_kontrak" type="text">
          </div>

          <div class="three fields">
            <div class="field">
              <label>Tanggal Kontrak</label>
              <input name="tanggal_kontrak" type="text">
            </div>

            <div class="field">
              <label>Tanggal Mulai</label>
              <input name="tanggal_mulai" type="text">
            </div>

            <div class="field">
            <label>Tanggal Selesai</label>
            <input name="tanggal_selesai" type="text">
          </div>
          </div>
          <div class="ui right submit button" @click.prevent="simpan">Simpan</div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Modal",
  methods:{
    simpan(){
      $('#form')//.addClass('loading')
        .form({
          inline : true,
          on     : 'blur',
          fields: {
            nama_proyek: {
              identifier  : 'nama_proyek',
              rules: [
                {
                  type   : 'empty',
                  prompt : 'Please enter your Username'
                }
              ]
            },
            nilai_kontrak: {
              identifier  : 'nilai_kontrak',
              rules: [
                {
                  type   : 'empty',
                  prompt : 'Please enter your password'
                },
                {
                  type   : 'length[6]',
                  prompt : 'Your password must be at least 6 characters'
                }
              ]
            },
            tanggal_kontrak: {
              identifier  : 'tanggal_kontrak',
              rules: [
                {
                  type   : 'empty',
                  prompt : 'Please enter your Username'
                }
              ]
            },
            tanggal_mulai: {
              identifier  : 'tanggal_mulai',
              rules: [
                {
                  type   : 'empty',
                  prompt : 'Please enter your Username'
                }
              ]
            },
            tanggal_selesai: {
              identifier  : 'tanggal_selesai',
              rules: [
                {
                  type   : 'empty',
                  prompt : 'Please enter your Username'
                }
              ]
            }
          },
          onSuccess(event, fields){
            var form = $(this).addClass('loading')
            var that = this
            axios.post('create-user')
              .then(res => {
                form.removeClass('loading')
                form.form('clear')
              })
              .catch(err => {
                form.removeClass('loading')
                form.form('clear')
                console.log(err.response)
              })
            event.preventDefault()
          }
        })
    }
  }
}
</script>

<style lang="css">
</style>
