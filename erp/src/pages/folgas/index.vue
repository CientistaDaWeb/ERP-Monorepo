<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Folgas"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <FolgasDatatable />
  </q-page>
</template>

<script>

import FolgasDatatable from '../../components/Folgas/datatable'

export default {
  components: { FolgasDatatable }
}
</script>

<style>

</style>
