<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Administradores de Condomínios"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <AdministradoresCondominioDatatable />
  </q-page>
</template>

<script>

import AdministradoresCondominioDatatable from '../../components/AdministradoresCondominio/datatable'

export default {
  components: { AdministradoresCondominioDatatable }
}
</script>

<style>

</style>
