<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Textos"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <TextosDatatable />
  </q-page>
</template>

<script>

import TextosDatatable from '../../components/Textos/datatable'

export default {
  components: { TextosDatatable }
}
</script>

<style>

</style>
