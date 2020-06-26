<template>
  <q-page padding>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        label="Dashboard"
        icon="fa fa-home"
      />
      <q-breadcrumbs-el label="Home" />
    </q-breadcrumbs>
    <div class="row q-col-gutter-md">
      <div class="col-12 col-md-6">
        <q-card
          class="bg-creamy-peach text-white"
        >
          <q-card-section>
            <div class="text-h6">
              Projetos - PPCI
            </div>
          </q-card-section>
          <q-separator />
          <q-card-section>
            <ProjetosDashboardPpci />
          </q-card-section>
        </q-card>
      </div>
      <div class="col-12 col-md-6">
        <q-card
          class="bg-sawtooth-aak text-white"
        >
          <q-card-section>
            <div class="text-h6">
              Projetos - Hidro
            </div>
          </q-card-section>
          <q-separator />
          <q-card-section>
            <ProjetosDashboardHidro />
          </q-card-section>
        </q-card>
      </div>
      <div class="col col-xs-12 col-sm-12 col-md-12">
        <q-card
          class="bg-pencil-lead text-white"
        >
          <q-card-section>
            <div class="text-h6">
              Compromissos
            </div>
          </q-card-section>
          <q-separator />
          <q-card-section>
            <AgendaDashboardCompromissos />
          </q-card-section>
        </q-card>
      </div>
      <div class="col col-xs-12 col-md-12">
        <q-card
          class="bg-blue-curacao text-white"
        >
          <q-card-section>
            <div class="text-h6">
              Contas a Receber
            </div>
          </q-card-section>
          <q-separator />
          <q-card-section>
            <div class="row q-col-gutter-md">
              <div class="col col-xs-12 col-md-6">
                <ContasReceberDashboardAtrasadas />
              </div>
              <div class="col col-xs-12 col-md-6">
                <ContasReceberDashboardVencendo />
              </div>
            </div>
          </q-card-section>
        </q-card>
      </div>
      <div class="col col-xs-12 col-md-12">
        <q-card
          class="bg-deep-rose text-white"
        >
          <q-card-section>
            <div class="text-h6">
              Contas a Pagar
            </div>
          </q-card-section>
          <q-separator />
          <q-card-section>
            <div class="row q-col-gutter-md">
              <div class="col col-xs-12 col-md-6">
                <ContasPagarDashboardAtrasadas />
              </div>
              <div class="col col-xs-12 col-md-6">
                <ContasPagarDashboardVencendo />
              </div>
            </div>
          </q-card-section>
        </q-card>
      </div>
      <div class="col col-xs-12 col-md-12">
        <q-card
          class="bg-brewed-mustard text-white"
        >
          <q-card-section>
            <div class="text-h6">
              Orçamentos com divergência de valores
            </div>
          </q-card-section>
          <q-separator />
          <q-card-section>
            <OrcamentosDashboardDivergencia />
          </q-card-section>
        </q-card>
      </div>
      <div class="col col-xs-12 col-md-12">
        <q-card
          class="bg-old-geranium text-white"
        >
          <q-card-section>
            <div class="text-h6">
              Atendimentos
            </div>
          </q-card-section>
          <q-separator />
          <q-card-section>
            <ClientesDashboardAtendimentos />
          </q-card-section>
        </q-card>
      </div>
      <div class="col col-xs-12 col-md-12">
        <q-card
          class="bg-purple-corallite text-white"
        >
          <q-card-section>
            <div class="text-h6">
              Ordens de Serviço
            </div>
          </q-card-section>
          <q-separator />
          <q-card-section>
            <div class="row q-col-gutter-md">
              <div class="col col-xs-12 col-md-6">
                <OrdensServicoDashboardAtrasadas />
              </div>
              <div class="col col-xs-12 col-md-6">
                <OrdensServicoDashboardVencendo />
              </div>
            </div>
          </q-card-section>
        </q-card>
      </div>
      <div class="col col-xs-12 col-md-12">
        <q-card
          class="bg-soft-blue text-white"
        >
          <q-card-section>
            <div class="text-h6">
              Orçamentos em aberto
            </div>
          </q-card-section>
          <q-separator />
          <q-card-section>
            <OrcamentosDashboardAbertos />
          </q-card-section>
        </q-card>
      </div>
    </div>
  </q-page>
</template>

<script>
import {
  QCard,
  QCardSection,
  QSeparator
} from 'quasar'
import ProjetosDashboardPpci from '../../components/Projetos/Dashboard/ppci'
import ProjetosDashboardHidro from '../../components/Projetos/Dashboard/hidro'
import AgendaDashboardCompromissos from '../../components/Agenda/Dashboard/compromissos'
import ContasReceberDashboardAtrasadas from '../../components/ContasReceber/Dashboard/atrasadas'
import ContasReceberDashboardVencendo from '../../components/ContasReceber/Dashboard/vencendo'
import ContasPagarDashboardVencendo from '../../components/ContasPagar/Dashboard/vencendo'
import ContasPagarDashboardAtrasadas from '../../components/ContasPagar/Dashboard/atrasadas'
import OrcamentosDashboardDivergencia from '../../components/Orcamentos/Dashboard/divergencia'
import ClientesDashboardAtendimentos from '../../components/Clientes/Dashboard/atendimentos'
import OrdensServicoDashboardAtrasadas from '../../components/OrdensServico/Dashboard/atrasadas'
import OrdensServicoDashboardVencendo from '../../components/OrdensServico/Dashboard/vencendo'
import OrcamentosDashboardAbertos from '../../components/Orcamentos/Dashboard/abertos'

export default {
  components: {
    OrcamentosDashboardAbertos,
    OrdensServicoDashboardVencendo,
    OrdensServicoDashboardAtrasadas,
    ClientesDashboardAtendimentos,
    OrcamentosDashboardDivergencia,
    ContasPagarDashboardAtrasadas,
    ContasPagarDashboardVencendo,
    ContasReceberDashboardVencendo,
    ContasReceberDashboardAtrasadas,
    AgendaDashboardCompromissos,
    ProjetosDashboardHidro,
    ProjetosDashboardPpci,
    QCard,
    QCardSection,
    QSeparator
  },
  computed: {},
  meta: () => ({
    title: 'Dashboard'
  })
}
</script>
