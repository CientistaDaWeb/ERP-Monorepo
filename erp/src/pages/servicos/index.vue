<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Serviços"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <ServicosDatatable />
  </q-page>
</template>

<script>

import ServicosDatatable from '../../components/Servicos/datatable'

export default {
  components: { ServicosDatatable }
}
</script>

<style>

</style>
