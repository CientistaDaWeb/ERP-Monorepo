<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Aditivos"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <AditivosDatatable />
  </q-page>
</template>

<script>

import AditivosDatatable from '../../components/Aditivos/datatable'

export default {
  components: { AditivosDatatable }
}
</script>

<style>

</style>
