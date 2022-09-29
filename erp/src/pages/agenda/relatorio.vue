<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Compromissos"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Relatório" />
    </q-breadcrumbs>
    <br>
    <AgendaRelatorio />
  </q-page>
</template>

<script>

import AgendaRelatorio from '../../components/Agenda/relatorio'

export default {
  components: { AgendaRelatorio }
}
</script>

<style>

</style>
