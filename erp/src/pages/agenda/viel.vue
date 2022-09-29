<template>
  <q-page padding>
    <LayoutBreadcrumbList :module="module" />
    <AgendaViel />
  </q-page>
</template>

<script>
import LayoutBreadcrumbList from '../../components/_Layout/breadcrumbList'
import AgendaViel from '../../components/Agenda/viel'

export default {
  components: {
    AgendaViel,
    LayoutBreadcrumbList
  },
  computed: {
    module () {
      return this.$store.state.agenda.module
    }
  }
}
</script>
