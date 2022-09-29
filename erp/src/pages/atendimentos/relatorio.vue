<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Atendimentos"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Relatório" />
    </q-breadcrumbs>
    <br>
    <clientesCrmRelatorio />
  </q-page>
</template>

<script>

import ClientesCrmRelatorio from '../../components/Clientes/Crm/relatorio'

export default {
  components: { ClientesCrmRelatorio }
}
</script>

<style>

</style>
