<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="CT-es Acqualife"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Importar" />
    </q-breadcrumbs>
    <br>
    <ImportarForm />
  </q-page>
</template>

<script>

import ImportarForm from '../../components/CtesAcqualife/importar'

export default {
  components: { ImportarForm }
}
</script>

<style>

</style>
