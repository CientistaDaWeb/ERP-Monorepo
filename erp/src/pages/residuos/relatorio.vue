<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Resíduos"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Relatório" />
    </q-breadcrumbs>
    <br>
    <ResiduosRelatorio />
  </q-page>
</template>

<script>

import ResiduosRelatorio from '../../components/Residuos/relatorio'

export default {
  components: { ResiduosRelatorio }
}
</script>

<style>

</style>
