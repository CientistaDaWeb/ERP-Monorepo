<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Clientes"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Relatório de Clientes por Administrador de Condomínio" />
    </q-breadcrumbs>
    <br>
    <AdministradoresCondominioRelatorio />
  </q-page>
</template>

<script>

import AdministradoresCondominioRelatorio from '../../components/AdministradoresCondominio/relatorio'

export default {
  components: { AdministradoresCondominioRelatorio }
}
</script>

<style>

</style>
