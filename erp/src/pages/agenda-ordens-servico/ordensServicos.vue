<template>
  <q-page padding>
    <LayoutBreadcrumbList :module="module" />
    <AgendaOrdensServicos />
  </q-page>
</template>

<script>
import LayoutBreadcrumbList from '../../components/_Layout/breadcrumbList'
import AgendaOrdensServicos from '../../components/AgendaOrdensServico/ordensServicos'

export default {
  components: {
    AgendaOrdensServicos,
    LayoutBreadcrumbList
  },
  computed: {
    module () {
      return this.$store.state.agenda.module
    }
  }
}
</script>
