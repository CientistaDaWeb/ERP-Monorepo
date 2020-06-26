<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Categorias de Contas a Pagar"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el>Editar Categoria de Contas a Pagar</q-breadcrumbs-el>
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
        <ContasPagarCategoriasForm
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
import ContasPagarCategoriasForm from '../../components/ContasPagarCategorias/form'

export default {
  components: {
    ContasPagarCategoriasForm,
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
      return this.$store.state.clientesCategorias.item
    }
  },
  mounted () {
    this.initTabs()
  }
}
</script>

<style>
</style>
