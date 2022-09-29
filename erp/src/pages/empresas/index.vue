<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Empresas"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <EmpresasDatatable />
  </q-page>
</template>

<script>

import EmpresasDatatable from '../../components/Empresas/datatable'

export default {
  components: { EmpresasDatatable }
}
</script>

<style>

</style>
