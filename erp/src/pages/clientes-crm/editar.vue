<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        icon="fa fa-align-justify"
        :to="`/clientes/${model.cliente_id} /editar`"
      >
        Editar Cliente {{ model.cliente_id }}
      </q-breadcrumbs-el>
      <q-breadcrumbs-el
        label="Atendimentos de Clientes"
        :to="{
          name: 'clientes.editar',
          params: { id: model.cliente_id, tab: 'atendimentos' }
        }"
      />

      <q-breadcrumbs-el>Editar Atendimento de Clientes {{ model.id }}</q-breadcrumbs-el>
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
        <ClientesCrmForm
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
import ClientesCrmForm from '../../components/Clientes/Crm/form'

export default {
  components: {
    ClientesCrmForm,
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
      return this.$store.state.clientesCrm.item
    }
  },
  mounted () {
    this.initTabs()
  }
}
</script>

<style>
</style>
