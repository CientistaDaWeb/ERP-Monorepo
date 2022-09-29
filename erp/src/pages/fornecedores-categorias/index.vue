<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Categorias de Fornecedores"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <FornecedoresCategoriasDatatable />
  </q-page>
</template>

<script>

import FornecedoresCategoriasDatatable from '../../components/FornecedoresCategorias/datatable'

export default {
  components: { FornecedoresCategoriasDatatable }
}
</script>

<style>

</style>
