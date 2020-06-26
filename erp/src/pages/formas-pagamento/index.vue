<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Formas de Pagamento"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <FormasPagamentoDatatable />
  </q-page>
</template>

<script>

import FormasPagamentoDatatable from '../../components/FormasPagamento/datatable'

export default {
  components: { FormasPagamentoDatatable }
}
</script>

<style>

</style>
