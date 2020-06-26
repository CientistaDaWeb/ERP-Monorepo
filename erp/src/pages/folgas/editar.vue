<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Folgas"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el>Editar Folga</q-breadcrumbs-el>
      <q-breadcrumbs-el>folga</q-breadcrumbs-el>
    </q-breadcrumbs>
    <br>
    <FolgaForm />
  </q-page>
</template>

<script>

import FolgaForm from '../../components/Folgas/form'

export default {
  components: {
    FolgaForm
  },
  data: () => ({
    action: 'new',
    tab: 'dados'
  })
}
</script>

<style>
</style>
