<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Módulos"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <ModulosDatatable />
  </q-page>
</template>

<script>

import ModulosDatatable from '../../components/Modulos/datatable'

export default {
  components: { ModulosDatatable }
}
</script>

<style>

</style>
