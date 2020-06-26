<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Mtrs"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <MtrsDatatable />
  </q-page>
</template>

<script>

import MtrsDatatable from '../../components/Mtrs/datatable'

export default {
  components: { MtrsDatatable }
}
</script>

<style>

</style>
