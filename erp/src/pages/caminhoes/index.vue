<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Caminhões"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <CaminhoesDatatable />
  </q-page>
</template>

<script>

import CaminhoesDatatable from '../../components/Caminhoes/datatable'

export default {
  components: { CaminhoesDatatable }
}
</script>

<style>

</style>
