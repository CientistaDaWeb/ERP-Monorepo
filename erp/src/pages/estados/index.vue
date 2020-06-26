<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Estados"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <EstadosDatatable />
  </q-page>
</template>

<script>

import EstadosDatatable from '../../components/Estados/datatable'

export default {
  components: { EstadosDatatable }
}
</script>

<style>

</style>
