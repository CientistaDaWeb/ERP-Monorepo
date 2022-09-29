<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Logs Acessos"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <LogsAcessosDatatable />
  </q-page>
</template>

<script>

import LogsAcessosDatatable from '../../components/LogsAcessos/datatable'

export default {
  components: { LogsAcessosDatatable }
}
</script>

<style>

</style>
