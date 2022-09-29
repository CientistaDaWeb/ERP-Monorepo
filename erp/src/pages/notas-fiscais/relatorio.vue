<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Notas Fiscais"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Relatório" />
    </q-breadcrumbs>
    <br>
    <NotasFiscaisRelatorio />
  </q-page>
</template>

<script>

import NotasFiscaisRelatorio from '../../components/NotasFiscais/relatorio'

export default {
  components: { NotasFiscaisRelatorio }
}
</script>

<style>

</style>
