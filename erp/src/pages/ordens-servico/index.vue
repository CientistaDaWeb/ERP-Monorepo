<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Ordens de Servico"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <OrdensServicoDatatable />
  </q-page>
</template>

<script>

import OrdensServicoDatatable from '../../components/OrdensServico/datatable'

export default {
  components: { OrdensServicoDatatable }
}
</script>

<style>

</style>
