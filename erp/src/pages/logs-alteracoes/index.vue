<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Logs Alterações"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <LogsAlteracoesDatatable />
  </q-page>
</template>

<script>

import LogsAlteracoesDatatable from '../../components/LogsAlteracoes/datatable'

export default {
  components: { LogsAlteracoesDatatable }
}
</script>

<style>

</style>
