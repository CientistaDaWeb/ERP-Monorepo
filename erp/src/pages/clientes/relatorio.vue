<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Clientes"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Relatório" />
    </q-breadcrumbs>
    <br>
    <ClientesRelatorio />
  </q-page>
</template>

<script>
import ClientesRelatorio from '../../components/Clientes/relatorio'

export default {
  components: { ClientesRelatorio }
}
</script>

<style>

</style>
