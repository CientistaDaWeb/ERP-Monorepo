<template>
  <div>
    Carregando
  </div>
</template>

<script>
export default {
  name: 'Loader',
  data () {
    return {}
  },
  beforeCreate: function () {
    this.$q.loading.show()
  },
  mounted () {
    this.$q.loading.hide()
  }
}
</script>

<style>
</style>
