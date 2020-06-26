<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Clientes"
        icon="fa fa-align-justify"
      />
      <q-breadcrumbs-el>Editar Cliente</q-breadcrumbs-el>
      <q-breadcrumbs-el>{{ model.razao_social }}</q-breadcrumbs-el>
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
        name="enderecos"
        label="Endereços"
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
        name="orcamentos"
        label="Orçamentos"
      />
      <q-tab
        name="ordens-servico"
        label="Ordens de Serviço"
      />
      <q-tab
        name="faturas"
        label="Faturas"
      />
      <q-tab
        name="contratos"
        label="Contratos"
      />
      <q-tab
        name="certificados"
        label="Certificados"
      />
      <q-tab
        name="notas_fiscais"
        label="Notas Fiscais"
      />
      <q-tab
        name="ctes"
        label="CT-es"
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
        <ClientesForm
          :id="id"
          :action="action"
        />
      </q-tab-panel>
      <q-tab-panel
        name="enderecos"
        class="tab-pane-content"
      >
        <ClientesEnderecosDatatable
          :cliente_id="id"
        />
      </q-tab-panel>
      <q-tab-panel
        name="telefones"
        class="tab-pane-content"
      >
        <ClientesTelefonesDatatable
          :cliente_id="id"
        />
      </q-tab-panel>
      <q-tab-panel
        name="atendimentos"
        class="tab-pane-content"
      >
        <ClientesCrmDatatable
          :cliente_id="id"
        />
      </q-tab-panel>
      <q-tab-panel
        name="orcamentos"
        class="tab-pane-content"
      >
        <OrcamentosDatatable
          :cliente_id="id"
        />
      </q-tab-panel>
      <q-tab-panel
        name="ordens-servico"
        class="tab-pane-content"
      >
        <ClientesOrdensServicoDatatable
          :cliente_id="id"
        />
      </q-tab-panel>
      <q-tab-panel
        name="faturas"
        class="tab-pane-content"
      >
        <ClientesContasReceberDatatable
          :cliente_id="id"
        />
      </q-tab-panel>
      <q-tab-panel
        name="contratos"
        class="tab-pane-content"
      >
        <ClientesContratosDatatable
          :cliente_id="id"
        />
      </q-tab-panel>
      <q-tab-panel
        name="certificados"
        class="tab-pane-content"
      >
        <ClientesCertificadosDatatable
          :cliente_id="id"
        />
      </q-tab-panel>
      <q-tab-panel
        name="notas_fiscais"
        class="tab-pane-content"
      >
        <ClientesNotasFiscaisDatatable
          :cliente_id="id"
        />
      </q-tab-panel>
      <q-tab-panel
        name="ctes"
        class="tab-pane-content"
      >
        Desenvolvimento
      </q-tab-panel>

      <q-tab-panel
        name="arquivos"
        class="tab-pane-content"
      >
        <ClientesArquivosDatatable
          :cliente_id="id"
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
import ClientesForm from '../../components/Clientes/form'
import ClientesEnderecosDatatable from '../../components/Clientes/Enderecos/datatable'
import ClientesTelefonesDatatable from '../../components/Clientes/Telefones/datatable'
import ClientesCrmDatatable from '../../components/Clientes/Crm/datatable'
import OrcamentosDatatable from '../../components/Clientes/Orcamentos/datatable'
import ClientesOrdensServicoDatatable from '../../components/Clientes/OrdensServico/datatable'
import ClientesContasReceberDatatable from '../../components/Clientes/ContasReceber/datatable'
import ClientesContratosDatatable from '../../components/Clientes/Contratos/datatable'
import ClientesCertificadosDatatable from '../../components/Clientes/Certificados/datatable'
import ClientesNotasFiscaisDatatable from '../../components/Clientes/NotasFiscais/datatable'
import ClientesArquivosDatatable from '../../components/Clientes/Arquivos/datatable'

export default {
  components: {
    ClientesArquivosDatatable,
    ClientesNotasFiscaisDatatable,
    ClientesCertificadosDatatable,
    ClientesContratosDatatable,
    ClientesContasReceberDatatable,
    ClientesOrdensServicoDatatable,
    OrcamentosDatatable,
    ClientesCrmDatatable,
    ClientesTelefonesDatatable,
    ClientesEnderecosDatatable,
    ClientesForm,
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
      return this.$store.state.clientes.item
    }
  },
  mounted () {
    this.initTabs()
  }
}
</script>

<style>
</style>
