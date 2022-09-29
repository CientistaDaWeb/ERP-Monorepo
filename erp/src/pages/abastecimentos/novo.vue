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
        <AbastecimentosForm />
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
import AbastecimentosForm from '../../components/Abastecimentos/form'
import LayoutBreadcrumbNovo from '../../components/_Layout/breadcrumbNovo'

export default {
  components: {
    LayoutBreadcrumbNovo,
    AbastecimentosForm,
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
      return this.$store.state.abastecimentos.module
    }
  }
}
</script>

<style>
</style>
