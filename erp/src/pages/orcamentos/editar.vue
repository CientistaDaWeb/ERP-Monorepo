<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Orçamentos"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el>Editar Orçamento {{ $route.params.id }}</q-breadcrumbs-el>
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
        name="servicos"
        label="Serviços"
      />
      <q-tab
        name="textos"
        label="Textos"
      />
      <q-tab
        name="visualizacao"
        label="Visualização"
      />
      <q-tab
        name="faturas"
        label="Faturas"
      />
      <q-tab
        name="ordensServico"
        label="Ordens de Serviço"
      />
      <q-tab
        name="notasFiscais"
        label="Notas Fiscais"
      />
      <q-tab
        name="contratos"
        label="Contratos"
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
        <OrcamentosForm
          :id="id"
          :action="action"
        />
      </q-tab-panel>
      <q-tab-panel
        name="servicos"
        class="tab-pane-content"
      >
        <OrcamentosServicosDatatable
          :orcamento-id="id"
        />
      </q-tab-panel>
      <q-tab-panel
        name="textos"
        class="tab-pane-content"
      >
        <OrcamentosTextosForm
          :id="id"
        />
      </q-tab-panel>

      <q-tab-panel
        name="visualizacao"
        class="tab-pane-content"
      >
        <OrcamentoVisualizar
          :orcamento_id="id"
        />
      </q-tab-panel>
      <q-tab-panel
        name="faturas"
        class="tab-pane-content"
      >
        <OrcamentosContasReceberDatatable
          :orcamento-id="id"
        />
      </q-tab-panel>
      <q-tab-panel
        name="ordensServico"
        class="tab-pane-content"
      >
        <OrcamentosOrdensServicoDatatable
          :orcamento-id="id"
        />
      </q-tab-panel>
      <q-tab-panel
        name="notasFiscais"
        class="tab-pane-content"
      >
        <OrcamentosNotasFiscaisDatatable
          :orcamento-id="id"
        />
      </q-tab-panel>
      <q-tab-panel
        name="contratos"
        class="tab-pane-content"
      >
        <OrcamentosContratosDatatable
          :orcamento-id="id"
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
import OrcamentosForm from '../../components/Orcamentos/form'
import OrcamentoVisualizar from '../../components/Orcamentos/Visualizar/form'
import OrcamentosTextosForm from '../../components/Orcamentos/Textos/form'
import OrcamentosContasReceberDatatable from '../../components/Orcamentos/ContasReceber/datatable'
import OrcamentosOrdensServicoDatatable from '../../components/Orcamentos/OrdensServico/datatable'
import OrcamentosNotasFiscaisDatatable from '../../components/Orcamentos/NotasFiscais/datatable'
import OrcamentosContratosDatatable from '../../components/Orcamentos/Contratos/datatable'
import OrcamentosServicosDatatable from '../../components/Orcamentos/Servicos/datatable'

export default {
  components: {
    OrcamentosServicosDatatable,
    OrcamentosContratosDatatable,
    OrcamentosNotasFiscaisDatatable,
    OrcamentosOrdensServicoDatatable,
    OrcamentosContasReceberDatatable,
    OrcamentosTextosForm,
    OrcamentosForm,
    OrcamentoVisualizar,
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
      return parseInt(this.$route.params.id)
    },
    model () {
      return this.$store.state.orcamentos.item
    }
  },
  mounted () {
    this.initTabs()
  }
}
</script>

<style>
</style>
