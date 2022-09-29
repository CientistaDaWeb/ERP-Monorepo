<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Cfops"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <CfopsDatatable />
  </q-page>
</template>

<script>

import CfopsDatatable from '../../components/Cfops/datatable'

export default {
  components: { CfopsDatatable }
}
</script>

<style>

</style>
