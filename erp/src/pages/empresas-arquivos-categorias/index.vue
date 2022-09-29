<template>
  <q-page padding>
    <LayoutBreadcrumbList :module="module" />
    <EmpresasArquivosCategoriasDatatable />
  </q-page>
</template>

<script>

import LayoutBreadcrumbList from '../../components/_Layout/breadcrumbList'
import EmpresasArquivosCategoriasDatatable from '../../components/EmpresasArquivosCategorias/datatable'

export default {
  components: {
    LayoutBreadcrumbList,
    EmpresasArquivosCategoriasDatatable
  },
  computed: {
    module () {
      return this.$store.state.empresasArquivosCategorias.module
    }
  }
}
</script>

<style>

</style>
