<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Contas a Receber"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Relatório" />
    </q-breadcrumbs>
    <br>
    <ContasReceberRelatorio />
  </q-page>
</template>

<script>

import ContasReceberRelatorio from '../../components/ContasReceber/relatorio'

export default {
  components: { ContasReceberRelatorio }
}
</script>

<style>

</style>
