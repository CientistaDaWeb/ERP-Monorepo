<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Contas a Pagar"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <ContasPagarDatatable />
  </q-page>
</template>

<script>

import ContasPagarDatatable from '../../components/ContasPagar/datatable'

export default {
  components: { ContasPagarDatatable }
}
</script>

<style>

</style>
