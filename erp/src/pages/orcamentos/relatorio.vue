<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Orçamentos"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Relatório" />
    </q-breadcrumbs>
    <br>
    <OrcamentosRelatorio />
  </q-page>
</template>

<script>
import OrcamentosRelatorio from '../../components/Orcamentos/relatorio'

export default {
  components: { OrcamentosRelatorio }
}
</script>

<style>

</style>
