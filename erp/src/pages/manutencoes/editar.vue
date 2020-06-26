<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Manutenções"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el>Editar Manutenções</q-breadcrumbs-el>
      <q-breadcrumbs-el>{{ model.name }}</q-breadcrumbs-el>
    </q-breadcrumbs>
    <br>
    <q-tabs
      v-model="tab"
      class="bg-primary text-white shadow-2"
      align="left"
    >
      <q-tab
        name="dados"
        label="Dados"
      />
      <q-tab
        name="pecas"
        label="Peças"
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
        <ManutencoesForm
          :id="id"
          :action="action"
        />
      </q-tab-panel>
      <q-tab-panel
        name="pecas"
        class="tab-pane-content"
      >
        <DesenvolvimentoIndex
          :manutencao_id="id"
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
import ManutencoesForm from '../../components/Manutencoes/form'
import DesenvolvimentoIndex from '../../components/Desenvolvimento/index'

export default {
  components: {
    DesenvolvimentoIndex,
    ManutencoesForm,
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
      return this.$store.state.manutencoes.item
    }
  },
  mounted () {
    this.initTabs()
  }
}
</script>

<style>
</style>
