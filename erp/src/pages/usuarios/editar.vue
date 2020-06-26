<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Usuários"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el>Editar Usuário</q-breadcrumbs-el>
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
        name="dados"
        class="tab-pane-content"
      >
        <UsuariosForm
          :id="id"
          :action="action"
        />
      </q-tab-panel>

      <q-tab-panel
        name="permissoes"
        class="tab-pane-content"
      >
        <PermissoesForm
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
      return this.$store.state.usuarios.item
    }
  },
  mounted () {
    this.initTabs()
  }
}
</script>

<style>
</style>
