<template>
  <q-page padding>
    <LayoutBreadcrumbList :module="module" />
    <AbastecimentosDatatable />
  </q-page>
</template>

<script>
import AbastecimentosDatatable from '../../components/Abastecimentos/datatable'
import LayoutBreadcrumbList from '../../components/_Layout/breadcrumbList'

export default {
  components: {
    LayoutBreadcrumbList,
    AbastecimentosDatatable
  },
  computed: {
    module () {
      return this.$store.state.abastecimentos.module
    }
  }
}
</script>
