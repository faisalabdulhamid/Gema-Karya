<template>
  <div>
    <router-link :to="{ name: 'index'}" class="item">
      <i class="block layout icon"></i>
      Proyek
    </router-link>
    <router-link :to="{ name: 'pekerjaan-index'}" class="item">
      <i class="block layout icon"></i>
      Pekerjaan
    </router-link>
    <router-link :to="{ name: 'resiko-index'}" class="item">
      <i class="block layout icon"></i>
      Resiko
    </router-link>
    <router-link :to="{ name: 'bahan-index'}" class="item">
      <i class="block layout icon"></i>
      Bahan
    </router-link>
    <router-link :to="{ name: 'pegawai-index'}" class="item">
      <i class="block layout icon"></i>
      Pegawai
    </router-link>
  </div>
</template>

<script>
export default {
  name: 'sidebarDirektur'
}
</script>

<style lang="css">
</style>
