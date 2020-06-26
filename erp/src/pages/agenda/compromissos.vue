<template>
  <q-page padding>
    <LayoutBreadcrumbList :module="module" />
    <AgendaCompromissos />
  </q-page>
</template>

<script>
import LayoutBreadcrumbList from '../../components/_Layout/breadcrumbList'
import AgendaCompromissos from '../../components/Agenda/compromissos'

export default {
  components: {
    AgendaCompromissos,
    LayoutBreadcrumbList
  },
  computed: {
    module () {
      return this.$store.state.agenda.module
    }
  }
}
</script>
