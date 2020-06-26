<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Projetos"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <ProjetosDatatable />
  </q-page>
</template>

<script>

import ProjetosDatatable from '../../components/Projetos/datatable'

export default {
  components: { ProjetosDatatable }
}
</script>

<style>

</style>
