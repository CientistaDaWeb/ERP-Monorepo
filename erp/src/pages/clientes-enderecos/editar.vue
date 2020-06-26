<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Endereços de Clientes"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el>Editar Endereço de Clientes</q-breadcrumbs-el>
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
        <ClientesEnderecosForm
          :id="id"
          :cliente_id="cliente_id"
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
import ClientesEnderecosForm from '../../components/Clientes/Enderecos/form'

export default {
  components: {
    ClientesEnderecosForm,
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
    cliente_id () {
      return this.$route.params.cliente_id
    },
    model () {
      return this.$store.state.clientesEnderecos.item
    }
  },
  mounted () {
    this.initTabs()
  }
}
</script>

<style>
</style>
