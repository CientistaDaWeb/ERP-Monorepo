<template>
  <div>
    <form
      @submit.prevent="filtrar"
      class="print-hide"
    >
      <q-card class="q-mb-md bg-primary text-white">
        <q-card-section>
          <div class="text-h6">
            Filtro
          </div>
        </q-card-section>
        <q-separator />
        <q-card-section class="bg-white text-black">
          <div class="row q-col-gutter-md q-mb-md">
            <div class="col col-sm-9 col-xs-12 self-center">
              &nbsp;
            </div>
            <div class="col col-sm-3 col-xs-12 text-right self-center">
              <q-btn-group>
                <q-btn
                  color="info"
                  glossy
                  @click="imprimir"
                  icon="fa fa-print"
                >
                  <q-tooltip>
                    Imprimir
                  </q-tooltip>
                </q-btn>
              </q-btn-group>
            </div>
          </div>
        </q-card-section>
      </q-card>
    </form>
    <div
      class="text-center"
      style="padding-top: 200px"
      v-if="loading"
    >
      <q-spinner-gears
        size="50px"
        color="primary"
      />
    </div>
    <div
      class="row q-col-gutter-md"
      v-if="showContent"
    >
      <div
        class="col col-xs-12"
        v-if="content.length"
      >
        <transition
          enter-active-class="animated bounceInLeft"
          leave-active-class="animated bounceOutRight"
          appear
        >
          <table
            ref="table"
            class="q-table table print-show"
          >
            <thead>
              <tr>
                <th>#</th>
                <th />
                <th>Código</th>
                <th>Cliente</th>
                <th>Último Orçamento</th>
                <th>Última Ordem de Serviço</th>
                <th>Administrador de Condomínio</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(d, i) in content"
                :key="d.id"
              >
                <td align="center">
                  {{ ++i }}
                </td>
                <td>
                  <q-checkbox
                    v-model="cliente_id"
                    :val="d.id"
                  />
                </td>
                <td align="center">
                  <q-btn
                    icon="fa fa-link"
                    round
                    glossy
                    size="xs"
                    color="primary"
                    class="print-hide float-left q-mr-md"
                    @click="$router.push({name:'clientes.editar', params: {id: d.id }})"
                  />
                  <span>{{ d.id }}</span>
                </td>
                <td>{{ d.razao_social }}</td>
                <td align="center">
                  {{ (d.ultimo_orcamento !== null)? d.ultimo_orcamento.data_emissao : '' |
                    formatDate('DD/MM/YYYY') }}
                </td>
                <td align="center">
                  {{ (d.ultimo_orcamento !== null && d.ultimo_orcamento.ultima_o_s !== null)?
                    d.ultimo_orcamento.ultima_o_s.data_coleta : '' | formatDate('DD/MM/YYYY') }}
                </td>
                <td>{{ (d.administrador !== null) ? d.administrador.nome : '' }}</td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <th colspan="5" />
                <th
                  colspan="3"
                  align="right"
                >
                  <q-btn
                    color="primary"
                    icon="fa fa-scroll"
                    @click="gerarEtiquetas"
                    label="Gerar Etiquetas"
                  />
                </th>
              </tr>
            </tfoot>
          </table>
        </transition>
      </div>
      <div
        class="col col-xs-12"
        v-else
      >
        <AlertEmptyContent />
      </div>
    </div>
  </div>
</template>

<script>
import {
  QBtn,
  QBtnGroup,
  QTooltip,
  QCard,
  QCardSection,
  QSeparator,
  QCheckbox,
  QSpinnerGears
} from 'quasar'
import _ from 'lodash'
import AlertEmptyContent from '../_Layout/alertEmptyContent'

export default {
  name: 'ClientesRelatorio',
  components: {
    AlertEmptyContent,
    QBtn,
    QBtnGroup,
    QTooltip,
    QCard,
    QCardSection,
    QSeparator,
    QCheckbox,
    QSpinnerGears
  },
  data: () => ({
    showContent: false,
    cliente_id: []
  }),
  methods: {
    getData () {
      this.filtrar()
    },
    filtrar () {
      this.showContent = false
      this.$store.dispatch('relatorios/relatorio', { relatorio: 'cliente', data: {} })
        .then(() => {
          this.showContent = true
        })
    },
    imprimir () {
      window.print()
    }
  },
  computed: {
    content () {
      return _.orderBy(this.$store.state.relatorios.content, 'razao_social', 'asc')
    },
    loading () {
      return this.$store.state.relatorios.loading
    }
  },
  mounted () {
    this.getData()
  }
}
</script>

<style>
</style>
