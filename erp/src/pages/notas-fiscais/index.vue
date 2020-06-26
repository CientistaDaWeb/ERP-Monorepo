<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Notas Fiscais"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <NotasFiscaisDatatable />
  </q-page>
</template>

<script>

import NotasFiscaisDatatable from '../../components/NotasFiscais/datatable'

export default {
  components: { NotasFiscaisDatatable }
}
</script>

<style>

</style>
