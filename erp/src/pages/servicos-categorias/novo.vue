<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Categorias de Servicos"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el>Nova Categoria de Serviços</q-breadcrumbs-el>
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
    <q-selector />
    <q-tab-panels
      v-model="tab"
      animated
    >
      <q-tab-panel
        name="dados"
        class="tab-pane-content"
      >
        <ServicosCategoriasForm />
      </q-tab-panel>
    </q-tab-panels>
  </q-page>
</template>

<script>
import {
  QTabs,
  QTab,
  QTabPanels,
  QTabPanel
} from 'quasar'
import ServicosCategoriasForm from '../../components/ServicosCategorias/form'

export default {
  components: {
    ServicosCategoriasForm,
    QTabs,
    QTab,
    QTabPanels,
    QTabPanel
  },
  data: () => ({
    action: 'new',
    tab: 'dados'
  })
}
</script>

<style>
</style>
