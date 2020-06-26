<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Usuários"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el>Novo Usuário</q-breadcrumbs-el>
    </q-breadcrumbs>
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
        name="permissoes"
        label="Permissões"
      />
    </q-tabs>
    <q-separator />
    <q-tab-panels
      v-model="tab"
      animated
    >
      <q-tab-panel
        name="Dados"
        class="tab-pane-content"
      >
        <UsuariosForm />
      </q-tab-panel>
      <q-tab-panel
        name="permissoes"
        class="tab-pane-content"
      >
        <PermissoesForm />
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
import UsuariosForm from '../../components/Usuarios/form'
import PermissoesForm from '../../components/Usuarios/permissoes'

export default {
  components: {
    UsuariosForm,
    PermissoesForm,
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
