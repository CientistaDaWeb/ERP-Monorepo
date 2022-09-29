<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Peças"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <PecasDatatable />
  </q-page>
</template>

<script>

import PecasDatatable from '../../components/Pecas/datatable'

export default {
  components: { PecasDatatable }
}
</script>

<style>

</style>
