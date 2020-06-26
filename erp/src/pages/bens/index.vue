<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Investimentos"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <BensDatatable />
  </q-page>
</template>

<script>

import BensDatatable from '../../components/Bens/datatable'

export default {
  components: { BensDatatable }
}
</script>

<style>

</style>
