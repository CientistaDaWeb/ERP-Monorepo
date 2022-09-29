<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Manutenções"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <ManutencoesDatatable />
  </q-page>
</template>

<script>

import ManutencoesDatatable from '../../components/Manutencoes/datatable'

export default {
  components: { ManutencoesDatatable }
}
</script>

<style>

</style>
