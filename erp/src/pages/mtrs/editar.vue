<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        :to="`/orcamentos/${$route.params.orcamento_id}/editar`"
        icon="fa fa-align-justify"
      >
        Orçamento {{ $route.params.orcamento_id }}
      </q-breadcrumbs-el>
      <q-breadcrumbs-el
        :to="`/ordens-servico/${$route.params.ordem_servico_id}/editar`"
      >
        Ordem  de Serviço {{ $route.params.ordem_servico_id }}
      </q-breadcrumbs-el>

      <q-breadcrumbs-el>Editar Mtr {{ $route.params.id }}</q-breadcrumbs-el>
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
        name="certificado"
        label="Certificado"
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
        <MtrsForm
          :id="parseInt(id)"
          :action="action"
        />
      </q-tab-panel>
      <q-tab-panel
        name="certificado"
        class="tab-pane-content"
      >
        <CertificadosForm
          :mtr-id="parseInt(id)"
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
import MtrsForm from '../../components/Mtrs/form'
import CertificadosForm from '../../components/Certificados/form'

export default {
  components: {
    MtrsForm,
    CertificadosForm,
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
      return this.$store.state.mtrs.item
    }
  },
  mounted () {
    this.initTabs()
    console.log(this.$route)
  }
}
</script>

<style>
</style>
