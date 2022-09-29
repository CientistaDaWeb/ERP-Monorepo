<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Contratos"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Relatório" />
    </q-breadcrumbs>
    <br>
    <ContratosRelatorio />
  </q-page>
</template>

<script>

import ContratosRelatorio from '../../components/Contratos/relatorio'

export default {
  components: { ContratosRelatorio }
}
</script>

<style>

</style>
