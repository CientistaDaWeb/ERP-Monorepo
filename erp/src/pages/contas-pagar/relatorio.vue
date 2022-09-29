<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Contas a Pagar"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Relatório" />
    </q-breadcrumbs>
    <br>
    <ContasPagarRelatorio />
  </q-page>
</template>

<script>

import ContasPagarRelatorio from '../../components/ContasPagar/relatorio'

export default {
  components: { ContasPagarRelatorio }
}
</script>

<style>

</style>
