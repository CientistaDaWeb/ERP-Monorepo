<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Municipios"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <MunicipiosDatatable />
  </q-page>
</template>

<script>

import MunicipiosDatatable from '../../components/Municipios/datatable'

export default {
  components: { MunicipiosDatatable }
}
</script>

<style>

</style>
