<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Clientes"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el>Novo Cliente</q-breadcrumbs-el>
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
        <ClientesForm />
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
import ClientesForm from '../../components/Clientes/form'

export default {
  components: {
    ClientesForm,
    QTabs,
    QTab,
    QTabPanels,
    QTabPanel,
    QSeparator
  },
  data: () => ({
    action: 'new',
    tab: 'dados'
  })
}
</script>

<style>
</style>
