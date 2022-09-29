<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Arquitetos"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <ArquitetosDatatable />
  </q-page>
</template>

<script>

import ArquitetosDatatable from '../../components/Arquitetos/datatable'

export default {
  components: { ArquitetosDatatable }
}
</script>

<style>

</style>
