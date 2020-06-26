<template>
  <q-page padding>
    <LayoutBreadcrumbEditar :module="module" />
    <q-tabs
      v-model="tab"
      class="bg-primary text-white shadow-2"
      align="left"
    >
      <q-tab
        name="dados"
        label="Dados"
      />
    </q-tabs>
    <q-separator />
    <q-tab-panels
      v-model="tab"
      animated
    >
      <q-tab-panel
        name="dados"
        class="tab-pane-content"
      >
        <TransportadoresForm
          :id="id"
          :action="action"
        />
      </q-tab-panel>
    </q-tab-panels>
  </q-page>
</template>

<script>
import {
  QTabs,
  QTab,
  QTabPanels,
  QTabPanel,
  QSeparator
} from 'quasar'
import TransportadoresForm from '../../components/Transportadores/form'
import LayoutBreadcrumbEditar from '../../components/_Layout/breadcrumbEditar'

export default {
  components: {
    LayoutBreadcrumbEditar,
    TransportadoresForm,
    QTabs,
    QTab,
    QTabPanels,
    QTabPanel,
    QSeparator
  },
  data: () => ({
    action: 'edit',
    tab: 'dados'
  }),
  methods: {
    initTabs () {
      if (this.$route.params.tab) {
        this.tab = this.$route.params.tab
      }
    }
  },
  computed: {
    id () {
      return this.$route.params.id
    },
    model () {
      return this.$store.state.transportadores.item
    },
    module () {
      return this.$store.state.transportadores.module
    }
  },
  mounted () {
    this.initTabs()
  }
}
</script>

<style>
</style>
