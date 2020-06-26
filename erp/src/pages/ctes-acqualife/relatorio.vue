<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="CT-es Acqualife"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Relatório" />
    </q-breadcrumbs>
    <br>
    <CtesAcqualifeRelatorio />
  </q-page>
</template>

<script>

import CtesAcqualifeRelatorio from '../../components/CtesAcqualife/relatorio'

export default {
  components: { CtesAcqualifeRelatorio }
}
</script>

<style>

</style>
