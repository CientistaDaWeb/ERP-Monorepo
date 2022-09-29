<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Clientes"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Relatório de Clientes Atendidos" />
    </q-breadcrumbs>
    <br>
    <CadastradosRelatorio />
  </q-page>
</template>

<script>

import CadastradosRelatorio from '../../components/Cadastrados/relatorio'

export default {
  components: { CadastradosRelatorio }
}
</script>

<style>

</style>
