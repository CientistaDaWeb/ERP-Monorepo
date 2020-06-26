<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Retornos"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <RetornosDatatable />
  </q-page>
</template>

<script>

import RetornosDatatable from '../../components/Retornos/datatable'

export default {
  components: { RetornosDatatable }
}
</script>

<style>

</style>
