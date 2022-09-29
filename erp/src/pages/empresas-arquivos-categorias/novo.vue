<template>
  <q-page padding>
    <LayoutBreadcrumbNovo :module="module" />
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
        <EmpresasArquivosCategoriasForm />
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
import LayoutBreadcrumbNovo from '../../components/_Layout/breadcrumbNovo'
import EmpresasArquivosCategoriasForm from '../../components/EmpresasArquivosCategorias/form'

export default {
  components: {
    EmpresasArquivosCategoriasForm,
    LayoutBreadcrumbNovo,
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
    module () {
      return this.$store.state.empresasArquivosCategorias.module
    }
  }
}
</script>

<style>
</style>
