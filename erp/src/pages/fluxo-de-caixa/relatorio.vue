<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Fluxo de Caixa"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Relatório" />
    </q-breadcrumbs>
    <br>
    <FluxoCaixaRelatorio />
  </q-page>
</template>

<script>

import FluxoCaixaRelatorio from '../../components/FluxoCaixa/relatorio'
export default {
  components: {
    FluxoCaixaRelatorio
  }
}
</script>

<style>

</style>
