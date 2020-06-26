<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Agenda"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el>Novo Compromisso</q-breadcrumbs-el>
    </q-breadcrumbs>
    <br>
    <CompromissoForm />
  </q-page>
</template>

<script>

import CompromissoForm from '../../components/Agenda/form'

export default {
  components: {
    CompromissoForm
  },
  data: () => ({
    action: 'new',
    tab: 'dados'
  })
}
</script>

<style>
</style>
