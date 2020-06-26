<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Categorias de Telefones"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <TelefonesCategoriasDatatable />
  </q-page>
</template>

<script>

import TelefonesCategoriasDatatable from '../../components/TelefonesCategorias/datatable'

export default {
  components: { TelefonesCategoriasDatatable }
}
</script>

<style>

</style>
