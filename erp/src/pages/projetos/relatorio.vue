<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Projetos"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Relatório" />
    </q-breadcrumbs>
    <br>
    <ProjetosRelatorio />
  </q-page>
</template>

<script>

import ProjetosRelatorio from '../../components/Projetos/relatorio'

export default {
  components: { ProjetosRelatorio }
}
</script>

<style>

</style>
