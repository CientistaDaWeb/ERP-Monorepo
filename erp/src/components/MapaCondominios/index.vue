<template>
  <div>
    <q-banner
      icon="fas fa-map-marker-alt"
      appear
      class="q-mb-sm bg-info text-white"
    >
      Clique no marcador para mais informações do local!
    </q-banner>
    <GmapMap
      :center="center"
      :zoom="17"
      style="width: 100%; height: 800px"
      v-if="!loading"
    >
      <GmapMarker
        :key="m.id"
        v-for="(m, i) in markers"
        :position="m.position"
        :clickable="true"
        :draggable="false"
        @click="marker = m"
        @mouseover="mostraInfo(m, i)"
        @mouseout="mostraInfo({}, null)"
      />
      <gmap-info-window
        :options="infoOptions"
        :position="infoWindowPos"
        :opened="infoWinOpen"
        @closeclick="infoWinOpen=false"
      >
        {{ infoContent }}
      </gmap-info-window>
      <div
        slot="visible"
        v-if="marker"
      >
        <q-card
          style="position: absolute; bottom: 10px; left: 10px; width: 300px"
          color="bg-primary text-white"
        >
          <q-btn
            style="z-index: 9000"
            class="absolute-top-right q-pa-xs"
            glossy
            icon="fa fa-times-circle"
            color="negative"
            @click="marker = ''"
          />
          <q-card-media>
            <img :src="marker.fachada">
          </q-card-media>
          <q-card-section>
            <div class="text-h6">
              {{ marker.cliente.razao_social }}
              <span
                slot="subtitle"
                class="text-white"
              > ({{ marker.categoria.categoria }})</span>
            </div>
          </q-card-section>
          <q-card-section>
            {{ marker.endereco }}, {{ marker.numero }} {{ marker.complemento }} - {{ marker.bairro }}
          </q-card-section>
        </q-card>
      </div>
    </GmapMap>
    <div
      class="text-center"
      style="padding-top: 200px"
      v-if="loading"
    >
      <q-spinner-gears
        size="50px"
        color="primary"
      />
    </div>
  </div>
</template>
<script>
import {
  QBtn,
  QCard,
  QCardSection,
  QBanner,
  QSpinnerGears
} from 'quasar'

export default {
  components: {
    QBtn,
    QCard,
    QCardSection,
    QBanner,
    QSpinnerGears
  },
  name: 'MapaCondominio',
  data: () => ({
    marker: '',
    center: { lat: -29.1715253, lng: -51.5168625 },
    infoContent: '',
    infoWindowPos: null,
    infoWinOpen: false,
    currentMidx: null,
    infoOptions: {
      pixelOffset: {
        width: 0,
        height: -35
      }
    }
  }),
  methods: {
    getData () {
      this.$store.dispatch('clientesEnderecos/loadListMapa', {})
    },
    mostraInfo (marker, idx) {
      this.infoWindowPos = marker.position
      if (marker.cliente) {
        this.infoContent = marker.cliente.razao_social
      } else {
        this.infoContent = ''
      }

      if (this.currentMidx === idx) {
        this.infoWinOpen = !this.infoWinOpen
      } else {
        this.infoWinOpen = true
        this.currentMidx = idx
      }
    }
  },
  computed: {
    markers () {
      return this.$store.state.clientesEnderecos.listMapa
    },
    loading: {
      get () {
        return this.$store.state.clientesEnderecos.loading
      },
      set (value) {
        this.$store.commit('clientesEnderecos/setLoading', value)
      }
    },
    module () {
      return this.$store.state.clientesEnderecos.module
    }
  },
  mounted () {
    this.getData()
  }
}
</script>
