<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Livro Ponto"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el>Editar Livro</q-breadcrumbs-el>
    </q-breadcrumbs>
    <br>
    <LivroPontoForm />
  </q-page>
</template>

<script>

import LivroPontoForm from '../../components/LivroPonto/form'

export default {
  components: {
    LivroPontoForm
  }
}
</script>

<style>
</style>
