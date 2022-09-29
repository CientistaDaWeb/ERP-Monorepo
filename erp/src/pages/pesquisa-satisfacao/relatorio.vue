<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Pesquisa Satisfação"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Relatório" />
    </q-breadcrumbs>
    <br>
    <PesquisaSatisfacaoRelatorio />
  </q-page>
</template>

<script>

import PesquisaSatisfacaoRelatorio from '../../components/PesquisaSatisfacao/relatorio'

export default {
  components: { PesquisaSatisfacaoRelatorio }
}
</script>

<style>

</style>
