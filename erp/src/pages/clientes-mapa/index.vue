<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Mapa de Condomínios"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el label="mapa" />
    </q-breadcrumbs>
    <br>
    <MapaCondominio />
  </q-page>
</template>

<script>

import MapaCondominio from '../../components/MapaCondominios/index'

export default {
  components: {
    MapaCondominio
  }
}
</script>

<style>

</style>
