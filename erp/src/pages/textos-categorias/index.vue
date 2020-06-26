<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Categorias de Textos"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <TextosCategoriasDatatable />
  </q-page>
</template>

<script>

import TextosCategoriasDatatable from '../../components/TextosCategorias/datatable'

export default {
  components: { TextosCategoriasDatatable }
}
</script>

<style>

</style>
