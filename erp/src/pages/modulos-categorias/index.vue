<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Categorias de Módulos"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <ModulosCategoriasDatatable />
  </q-page>
</template>

<script>

import ModulosCategoriasDatatable from '../../components/ModulosCategorias/datatable'

export default {
  components: { ModulosCategoriasDatatable }
}
</script>

<style>

</style>
