<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Construtoras"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <ConstrutorasDatatable />
  </q-page>
</template>

<script>

import ConstrutorasDatatable from '../../components/Construtoras/datatable'

export default {
  components: { ConstrutorasDatatable }
}
</script>

<style>

</style>
