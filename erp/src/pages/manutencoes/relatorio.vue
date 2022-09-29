<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Manutenções"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Relatório" />
    </q-breadcrumbs>
    <br>
    <ManutencaoRelatorio />
  </q-page>
</template>

<script>
import ManutencaoRelatorio from '../../components/Manutencoes/relatorio'

export default {
  components: { ManutencaoRelatorio }
}
</script>

<style>

</style>
