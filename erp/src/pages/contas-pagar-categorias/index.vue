<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Categorias de Contas a Pagar"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <ContasPagarCategoriasDatatable />
  </q-page>
</template>

<script>

import ContasPagarCategoriasDatatable from '../../components/ContasPagarCategorias/datatable'

export default {
  components: { ContasPagarCategoriasDatatable }
}
</script>

<style>

</style>
