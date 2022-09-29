<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Orçamentos"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <OrcamentosDatatable />
  </q-page>
</template>

<script>

import OrcamentosDatatable from '../../components/Orcamentos/datatable'

export default {
  components: { OrcamentosDatatable }
}
</script>

<style>

</style>
