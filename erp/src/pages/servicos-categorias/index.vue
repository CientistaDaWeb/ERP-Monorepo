<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Categorias de Serviços"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <ServicosCategoriasDatatable />
  </q-page>
</template>

<script>

import ServicosCategoriasDatatable from '../../components/ServicosCategorias/datatable'

export default {
  components: { ServicosCategoriasDatatable }
}
</script>

<style>

</style>
