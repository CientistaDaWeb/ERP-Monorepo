<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="CT-es Acquaservicos"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Relatório" />
    </q-breadcrumbs>
    <br>
    <CtesAcquaservicosRelatorio />
  </q-page>
</template>

<script>

import CtesAcquaservicosRelatorio from '../../components/CtesAcquaservicos/relatorio'

export default {
  components: { CtesAcquaservicosRelatorio }
}
</script>

<style>

</style>
