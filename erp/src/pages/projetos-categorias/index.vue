<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Categorias de Projetos"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <ProjetosCategoriasDatatable />
  </q-page>
</template>

<script>

import ProjetosCategoriasDatatable from '../../components/ProjetosCategorias/datatable'

export default {
  components: { ProjetosCategoriasDatatable }
}
</script>

<style>

</style>
