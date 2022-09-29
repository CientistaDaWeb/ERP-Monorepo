<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        :to="`/orcamentos/${$route.params.orcamento_id} /editar`"
        icon="fa fa-align-justify"
      >
        Orçamento {{ $route.params.orcamento_id }}
      </q-breadcrumbs-el>
      <q-breadcrumbs-el>
        Ordens de Serviço
      </q-breadcrumbs-el>

      <q-breadcrumbs-el>Editar Ordem de Serviço {{ $route.params.id }}</q-breadcrumbs-el>
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
        name="mtrs"
        label="MTRs"
      />
      <q-tab
        name="imagens"
        label="Imagens"
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
        <OrdensServicoForm
          :id="id"
          :action="action"
        />
      </q-tab-panel>
      <q-tab-panel
        name="servicos"
        class="tab-pane-content"
      >
        <OrdemServicoServico
          :ordem-servico-id="id"
        />
      </q-tab-panel>
      <q-tab-panel
        name="mtrs"
        class="tab-pane-content"
      >
        <MtrIndex
          :ordem-servico-id="id"
        />
      </q-tab-panel>
      <q-tab-panel
        name="imagens"
        class="tab-pane-content"
      >
        <OrdemServicoImagens
          :ordem-servico-id="id"
        />
      </q-tab-panel>
      <q-tab-panel
        name="arquivos"
        class="tab-pane-content"
      >
        <OrdemServicoArquivos
          :ordem-servico-id="id"
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
import OrdensServicoForm from '../../components/OrdensServico/form'
import OrdemServicoServico from '../../components/OrdensServico/servico'
import OrdemServicoImagens from '../../components/OrdensServico/imagens'
import OrdemServicoArquivos from '../../components/OrdensServico/arquivos'
import MtrIndex from '../../components/OrdensServico/mtrIndex'

export default {
  components: {
    OrdemServicoServico,
    OrdensServicoForm,
    OrdemServicoImagens,
    OrdemServicoArquivos,
    MtrIndex,
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
      return this.$store.state.ordensServico.item
    }
  },
  mounted () {
    console.log(this.$route.params.orcamento_id)
    this.initTabs()
  }
}
</script>

<style>
</style>
