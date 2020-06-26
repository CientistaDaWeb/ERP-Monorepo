<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Categorias de Clientes"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <ClientesCategoriasDatatable />
  </q-page>
</template>

<script>

import ClientesCategoriasDatatable from '../../components/ClientesCategorias/datatable'

export default {
  components: { ClientesCategoriasDatatable }
}
</script>

<style>

</style>
