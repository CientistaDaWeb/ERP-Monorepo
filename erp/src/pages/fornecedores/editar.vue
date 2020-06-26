<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Fornecedores"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el>Editar Fornecedor</q-breadcrumbs-el>
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
        name="atendimentos"
        label="Atendimentos"
      />
      <q-tab
        name="arquivos"
        label="Arquivos"
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
        <FornecedoresForm
          :id="id"
          :action="action"
        />
      </q-tab-panel>
      <q-tab-panel
        name="atendimentos"
        class="tab-pane-content"
      >
        Desenvolvimento
      </q-tab-panel>
      <q-tab-panel
        name="arquivos"
        class="tab-pane-content"
      >
        Desenvolvimento
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
import FornecedoresForm from '../../components/Fornecedores/form'

export default {
  components: {
    FornecedoresForm,
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
      return this.$store.state.fornecedores.item
    }
  },
  mounted () {
    this.initTabs()
  }
}
</script>

<style>
</style>
