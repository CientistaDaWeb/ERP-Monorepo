<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Notas de Projetos"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <NotasProjetosDatatable />
  </q-page>
</template>

<script>

import NotasProjetosDatatable from '../../components/NotasProjetos/datatable'

export default {
  components: { NotasProjetosDatatable }
}
</script>

<style>

</style>
