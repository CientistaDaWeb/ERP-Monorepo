<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Usuários"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <UsuariosDatatable />
  </q-page>
</template>

<script>

import UsuariosDatatable from '../../components/Usuarios/datatable'

export default {
  components: { UsuariosDatatable }
}
</script>

<style>

</style>
