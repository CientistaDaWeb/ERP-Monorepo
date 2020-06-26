<template>
  <q-page padding>
    <LayoutBreadcrumbList :module="module" />
    <TransportadoresDatatable />
  </q-page>
</template>

<script>

import TransportadoresDatatable from '../../components/Transportadores/datatable'
import LayoutBreadcrumbList from '../../components/_Layout/breadcrumbList'

export default {
  components: {
    LayoutBreadcrumbList,
    TransportadoresDatatable
  },
  computed: {
    module () {
      return this.$store.state.transportadores.module
    }
  }
}
</script>

<style>

</style>
