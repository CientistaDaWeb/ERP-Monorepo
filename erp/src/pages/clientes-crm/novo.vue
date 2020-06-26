<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Atendimentos de Clientes"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el>Novo Atendimento de Clientes</q-breadcrumbs-el>
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
          :cliente_id="cliente_id"
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
    action: 'new',
    tab: 'dados'
  }),
  computed: {
    cliente_id () {
      return this.$route.params.cliente_id
    }
  }
}
</script>

<style>
</style>
