<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Livro Ponto"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Relatório" />
    </q-breadcrumbs>
    <br>
    <LivroPontoRelatorio />
  </q-page>
</template>

<script>

import LivroPontoRelatorio from '../../components/LivroPonto/relatorio'

export default {
  components: { LivroPontoRelatorio }
}
</script>

<style>

</style>
