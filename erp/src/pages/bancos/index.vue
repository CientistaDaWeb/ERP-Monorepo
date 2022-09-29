<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Bancos"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <BancosDatatable />
  </q-page>
</template>

<script>

import BancosDatatable from '../../components/Bancos/datatable'

export default {
  components: { BancosDatatable }
}
</script>

<style>

</style>
