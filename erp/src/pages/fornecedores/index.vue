<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Fornecedores"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <FornecedoresDatatable />
  </q-page>
</template>

<script>

import FornecedoresDatatable from '../../components/Fornecedores/datatable'

export default {
  components: { FornecedoresDatatable }
}
</script>

<style>

</style>
