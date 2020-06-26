<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Demonstrativo de Resultados"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Relatório" />
    </q-breadcrumbs>
    <br>
    <DresRelatorio />
  </q-page>
</template>

<script>

import DresRelatorio from '../../components/Dres/relatorio'

export default {
  components: { DresRelatorio }
}
</script>

<style>

</style>
