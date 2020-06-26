<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Clientes"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <ClientesDatatable />
  </q-page>
</template>

<script>

import ClientesDatatable from '../../components/Clientes/datatable'

export default {
  components: { ClientesDatatable }
}
</script>

<style>

</style>
