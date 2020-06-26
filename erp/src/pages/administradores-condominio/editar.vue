<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Administradores de Condomínio"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el>Editar Adminitrador de Condomínio</q-breadcrumbs-el>
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
        name="telefones"
        label="Telefones"
      />
      <q-tab
        name="atendimentos"
        label="Atendimentos"
      />
      <q-tab
        name="arquivos"
        label="Arquivos"
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
        <AdministradoresCondominioForm
          :id="id"
          :action="action"
        />
      </q-tab-panel>
      <q-tab-panel
        name="telefones"
        class="tab-pane-content"
      >
        <!-- <AdministradoresCondominioTelefonesForm /> -->
        <AdministradoresCondominioTelefonesDatatable />
      </q-tab-panel>
      <q-tab-panel
        name="atendimentos"
        class="tab-pane-content"
      >
        <!-- <AdministradoresCondominioAtendimentosForm /> -->
        <AdministradoresCondominioAtendimentosDatatable />
      </q-tab-panel>
      <q-tab-panel
        name="arquivos"
        class="tab-pane-content"
      >
        <q-uploader
          v-model="model.arquivos"
          flat
          bordered
          url="http://localhost"
          label="Enviar um arquivos"
          :error="errors.has('arquivos')"
          :error-message="errors.first('arquivos')"
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
  QSeparator,
  QUploader
} from 'quasar'
import AdministradoresCondominioForm from '../../components/AdministradoresCondominio/form'
// import AdministradoresCondominioTelefonesForm from '../../components/AdministradoresCondominio/Telefones/form'
import AdministradoresCondominioTelefonesDatatable from '../../components/AdministradoresCondominio/Telefones/datatable'
// import AdministradoresCondominioAtendimentosForm from '../../components/AdministradoresCondominio/Atendimentos/form'
import AdministradoresCondominioAtendimentosDatatable from '../../components/AdministradoresCondominio/Atendimentos/datatable'

export default {
  components: {
    AdministradoresCondominioForm,
    // AdministradoresCondominioTelefonesForm,
    AdministradoresCondominioTelefonesDatatable,
    // AdministradoresCondominioAtendimentosForm,
    AdministradoresCondominioAtendimentosDatatable,
    QTabs,
    QTab,
    QTabPanels,
    QTabPanel,
    QSeparator,
    QUploader
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
      return this.$store.state.aditivos.item
    }
  },
  mounted () {
    this.initTabs()
  }
}
</script>

<style>
</style>
