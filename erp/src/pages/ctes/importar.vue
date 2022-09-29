<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="CT-es"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Importar" />
    </q-breadcrumbs>
    <br>
    <ImportarForm />
  </q-page>
</template>

<script>

import ImportarForm from '../../components/Ctes/importar'

export default {
  components: { ImportarForm }
}
</script>

<style>

</style>
