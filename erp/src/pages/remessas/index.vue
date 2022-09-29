<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Remessas"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <RemessasDatatable />
  </q-page>
</template>

<script>

import RemessasDatatable from '../../components/Remessas/datatable'

export default {
  components: { RemessasDatatable }
}
</script>

<style>

</style>
