<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Certificados"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
    <CertificadosDatatable />
  </q-page>
</template>

<script>

import CertificadosDatatable from '../../components/Certificados/datatable'

export default {
  components: { CertificadosDatatable }
}
</script>

<style>

</style>
