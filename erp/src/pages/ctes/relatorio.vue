<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="CT-es"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Relatório" />
    </q-breadcrumbs>
    <br>
    <CtesRelatorio />
  </q-page>
</template>

<script>

import CtesRelatorio from '../../components/Ctes/relatorio'

export default {
  components: { CtesRelatorio }
}
</script>

<style>

</style>
