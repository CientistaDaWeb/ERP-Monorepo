<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Notas Projetos"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Relatório" />
    </q-breadcrumbs>
    <br>
    <NotasProjetosRelatorio />
  </q-page>
</template>

<script>

import NotasProjetosRelatorio from '../../components/NotasProjetos/relatorio'

export default {
  components: { NotasProjetosRelatorio }
}
</script>

<style>

</style>
