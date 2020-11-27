<template>
  <q-page padding>
    <q-breadcrumbs class="print-hide">
      <q-breadcrumbs-el
        label="Ordem de Seviço"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Relatório" />
    </q-breadcrumbs>
    <br>
    <OrdemServicoRelatorio />
  </q-page>
</template>

<script>

import OrdemServicoRelatorio from '../../components/OrdensServico/relatorio'

export default {
  components: {
    OrdemServicoRelatorio
  }
}
</script>

<style>

</style>
