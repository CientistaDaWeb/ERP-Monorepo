<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Contas a Receber"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <ContasReceberDatatable />
  </q-page>
</template>

<script>

import ContasReceberDatatable from '../../components/ContasReceber/datatable'

export default {
  components: { ContasReceberDatatable }
}
</script>

<style>

</style>
