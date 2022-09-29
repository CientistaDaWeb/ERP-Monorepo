<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Categorias de Endereços"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <EnderecosCategoriasDatatable />
  </q-page>
</template>

<script>

import EnderecosCategoriasDatatable from '../../components/EnderecosCategorias/datatable'

export default {
  components: { EnderecosCategoriasDatatable }
}
</script>

<style>

</style>
