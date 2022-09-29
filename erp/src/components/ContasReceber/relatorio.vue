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
            <div class="col col-sm-9 col-lg-10 col-xs-12 self-center">
              <div class="row q-col-gutter-md">
                <div class="col col-sm-4 col-xs-12">
                  <div class="row q-col-gutter-md">
                    <div class="col col-sm-12 col-xs-12">
                      <label>Data de Vencimento</label>
                    </div>
                    <div class="col col-sm-6 col-xs-12">
                      <q-input
                        v-model="data.data_vencimento_inicial"
                        label="Data Inicial"
                      >
                        <template v-slot:append>
                          <q-icon
                            name="fa fa-calendar"
                            class="cursor-pointer"
                          >
                            <q-popup-proxy
                              transition-show="scale"
                              ref="qDateProxy"
                              transition-hide="scale"
                            >
                              <q-date
                                today-btn
                                mask="DD/MM/YYYY"
                                v-model="data.data_vencimento_inicial"
                                @input="() => $refs.qDateProxy.hide()"
                              />
                            </q-popup-proxy>
                          </q-icon>
                        </template>
                      </q-input>
                    </div>
                    <div class="col col-sm-6 col-xs-12">
                      <q-input
                        v-model="data.data_vencimento_final"
                        label="Data Final"
                      >
                        <template v-slot:append>
                          <q-icon
                            name="fa fa-calendar"
                            class="cursor-pointer"
                          >
                            <q-popup-proxy
                              transition-show="scale"
                              ref="qDateProxy2"
                              transition-hide="scale"
                            >
                              <q-date
                                today-btn
                                mask="DD/MM/YYYY"
                                v-model="data.data_vencimento_final"
                                @input="() => $refs.qDateProxy2.hide()"
                              />
                            </q-popup-proxy>
                          </q-icon>
                        </template>
                      </q-input>
                    </div>
                  </div>
                </div>
                <div class="col col-sm-4 col-xs-12">
                  <div class="row q-col-gutter-md">
                    <div class="col col-sm-12 col-xs-12">
                      <label>Data de Pagamento</label>
                    </div>
                    <div class="col col-sm-6 col-xs-12">
                      <q-input
                        v-model="data.data_pagamento_inicial"
                        label="Data Inicial"
                      >
                        <template v-slot:append>
                          <q-icon
                            name="fa fa-calendar"
                            class="cursor-pointer"
                          >
                            <q-popup-proxy
                              transition-show="scale"
                              ref="qDateProxy3"
                              transition-hide="scale"
                            >
                              <q-date
                                today-btn
                                mask="DD/MM/YYYY"
                                v-model="data.data_pagamento_inicial"
                                @input="() => $refs.qDateProxy3.hide()"
                              />
                            </q-popup-proxy>
                          </q-icon>
                        </template>
                      </q-input>
                    </div>
                    <div class="col col-sm-6 col-xs-12">
                      <q-input
                        v-model="data.data_pagamento_final"
                        label="Data Final"
                      >
                        <template v-slot:append>
                          <q-icon
                            name="fa fa-calendar"
                            class="cursor-pointer"
                          >
                            <q-popup-proxy
                              transition-show="scale"
                              ref="qDateProxy4"
                              transition-hide="scale"
                            >
                              <q-date
                                today-btn
                                mask="DD/MM/YYYY"
                                v-model="data.data_pagamento_final"
                                @input="() => $refs.qDateProxy4.hide()"
                              />
                            </q-popup-proxy>
                          </q-icon>
                        </template>
                      </q-input>
                    </div>
                  </div>
                </div>
                <div class="col col-sm-4 col-xs-12">
                  <div class="row q-col-gutter-md">
                    <div class="col col-sm-12 col-xs-12">
                      <label>Data de Lançamento</label>
                    </div>
                    <div class="col col-sm-6 col-xs-12">
                      <q-input
                        v-model="data.data_lancamento_inicial"
                        label="Data Final"
                      >
                        <template v-slot:append>
                          <q-icon
                            name="fa fa-calendar"
                            class="cursor-pointer"
                          >
                            <q-popup-proxy
                              transition-show="scale"
                              ref="qDateProxy5"
                              transition-hide="scale"
                            >
                              <q-date
                                today-btn
                                mask="DD/MM/YYYY"
                                v-model="data.data_lancamento_inicial"
                                @input="() => $refs.qDateProxy5.hide()"
                              />
                            </q-popup-proxy>
                          </q-icon>
                        </template>
                      </q-input>
                    </div>
                    <div class="col col-sm-6 col-xs-12">
                      <q-input
                        v-model="data.data_lancamento_final"
                        label="Data Final"
                      >
                        <template v-slot:append>
                          <q-icon
                            name="fa fa-calendar"
                            class="cursor-pointer"
                          >
                            <q-popup-proxy
                              transition-show="scale"
                              ref="qDateProxy6"
                              transition-hide="scale"
                            >
                              <q-date
                                today-btn
                                mask="DD/MM/YYYY"
                                v-model="data.data_lancamento_final"
                                @input="() => $refs.qDateProxy6.hide()"
                              />
                            </q-popup-proxy>
                          </q-icon>
                        </template>
                      </q-input>
                    </div>
                  </div>
                </div>
                <div class="col col-sm-2 col-lg-2 col-xs-12">
                  <q-select
                    filter
                    :options="statusOptions"
                    v-model="data.status"
                    label="Status"
                  />
                </div>
                <div class="col col-sm-6 col-lg-6 col-xs-12">
                  <q-select
                    filter
                    :options="empresas"
                    v-model="data.empresa_id"
                    label="Empresa"
                  />
                </div>
                <div class="col col-sm-6 col-lg-6 col-xs-12">
                  <q-select
                    filter
                    :options="formasPagamento"
                    v-model="data.forma_pagamento_id"
                    label="Forma de Pagamento"
                  />
                </div>
                <div class="col col-sm-6 col-lg-6 col-xs-12">
                  <q-select
                    filter
                    :options="clientes"
                    v-model="data.cliente_id"
                    label="Cliente"
                  />
                </div>
                <div class="col col-sm-3 col-lg-3 col-xs-12">
                  <q-select
                    filter
                    :options="ordenacao"
                    v-model="order.campo"
                    label="Ordenação"
                  />
                </div>
                <div class="col col-sm-3 col-lg-3 col-xs-12">
                  <q-select
                    filter
                    :options="direcaoOrdenacao"
                    v-model="order.direcao"
                    label="Direção de Ordenação"
                  />
                </div>
              </div>
            </div>
            <div class="col col-sm-3 col-lg-2 col-xs-12 text-right self-center">
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
                <q-btn
                  color="info"
                  glossy
                  @click="exportar"
                  icon="fa fa-file-export"
                  :loading="loading"
                >
                  <q-tooltip>
                    Exportar em csv
                  </q-tooltip>
                </q-btn>
                <q-btn
                  type="submit"
                  :loading="loading"
                  color="positive"
                  glossy
                  icon="fa fa-filter"
                >
                  <q-tooltip>
                    Filtrar
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
                <th>Código</th>
                <th colspan="2">
                  Vencimento
                </th>
                <th colspan="2">
                  Pagamento
                </th>
                <th>Orçamento</th>
                <th>Cliente</th>
                <th>Empresa</th>
                <th>Forma Pag.</th>
                <th>CT-e</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="d in content"
                :key="d.id"
                :class="status(d.status)"
              >
                <td>
                  <q-btn
                    icon="fa fa-link"
                    round
                    glossy
                    size="xs"
                    color="primary"
                    class="print-hide float-left q-mr-md"
                    @click="$router.push({name:'contas-receber.editar', params: {id: d.id }})"
                  />
                  <span>{{ d.id }}</span>
                </td>
                <td>{{ d.data_vencimento | formatDate('DD/MM/YYYY') }}</td>
                <td align="right">
                  {{ d.valor | currency }}
                </td>
                <td>{{ d.data_pagamento | formatDate('DD/MM/YYYY') }}</td>
                <td align="right">
                  {{ d.valor_pago | currency }}
                </td>
                <td>
                  <q-btn
                    icon="fa fa-link"
                    round
                    glossy
                    size="xs"
                    color="primary"
                    class="print-hide float-left q-mr-md"
                    @click="$router.push({name:'orcamentos.editar', params: {id: d.orcamento.id }})"
                  />
                  <span>{{ d.orcamento.id }}</span>
                </td>
                <td>
                  <q-btn
                    icon="fa fa-link"
                    round
                    glossy
                    size="xs"
                    color="primary"
                    class="print-hide float-left q-mr-md"
                    @click="$router.push({name:'clientes.editar', params: {id: d.orcamento.cliente.id }})"
                  />
                  <span>{{ d.orcamento.cliente.razao_social }}</span>
                </td>
                <td>{{ d.empresa.razao_social }}</td>
                <td>{{ d.forma_pagamento.forma_pagamento }}</td>
                <td>?</td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <th align="right">
                  Valor Gerado
                </th>
                <th
                  align="right"
                  colspan="2"
                >
                  {{ content.map(data =>(data.valor)).reduce((a,b) => a + b ) | currency }}
                </th>
                <th align="right">
                  Valor Retido
                </th>
                <th
                  align="right"
                  colspan="2"
                >
                  {{ content.map(data =>(data.valor_retido)).reduce((a,b) => a + b ) |
                    currency
                  }}
                </th>
                <th align="right">
                  Valor Recebido
                </th>
                <th
                  align="right"
                  colspan="3"
                >
                  {{ content.map(data =>(data.valor_pago)).reduce((a,b) => a + b ) |
                    currency }}
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
  date,
  QInput,
  QBtn,
  QBtnGroup,
  QTooltip,
  QSelect,
  QDate,
  QPopupProxy,
  QCard,
  QCardSection,
  QSeparator,
  QSpinnerGears
} from 'quasar'
import _ from 'lodash'
import AlertEmptyContent from '../_Layout/alertEmptyContent'

export default {
  name: 'ContasReceberRelatorio',
  components: {
    AlertEmptyContent,
    QInput,
    QBtn,
    QBtnGroup,
    QTooltip,
    QSelect,
    QDate,
    QPopupProxy,
    QCard,
    QCardSection,
    QSeparator,
    QSpinnerGears
  },
  data: () => ({
    showContent: false,
    data: {
      data_vencimento_inicial: '',
      data_vencimento_final: '',
      status: ''
    },
    order: {
      campo: 'data_pagamento',
      direcao: 'asc'
    }
  }),
  methods: {
    getData () {
      const hoje = new Date()
      const passado = date.subtractFromDate(hoje, { month: 1 })
      this.data.data_vencimento_inicial = passado
      this.data.data_vencimento_final = hoje
      this.$store.dispatch('empresas/loadList', {})
      this.$store.dispatch('clientes/loadList', {})
      this.$store.dispatch('formasPagamento/loadList', {})
    },
    filtrar () {
      const data = Object.assign({}, this.data)
      this.showContent = false
      if (data.data_vencimento_inicial) {
        data.data_vencimento_inicial = date.formatDate(data.data_vencimento_inicial, 'YYYY-MM-DD')
      }
      if (data.data_vencimento_final) {
        data.data_vencimento_final = date.formatDate(data.data_vencimento_final, 'YYYY-MM-DD')
      }
      if (data.data_pagamento_inicial) {
        data.data_pagamento_inicial = date.formatDate(data.data_pagamento_inicial, 'YYYY-MM-DD')
      }
      if (data.data_pagamento_final) {
        data.data_pagamento_final = date.formatDate(data.data_pagamento_final, 'YYYY-MM-DD')
      }
      if (data.data_lancamento_inicial) {
        data.data_lancamento_inicial = date.formatDate(data.data_lancamento_inicial, 'YYYY-MM-DD')
      }
      if (data.data_lancamento_final) {
        data.data_lancamento_final = date.formatDate(data.data_lancamento_final, 'YYYY-MM-DD')
      }
      this.$store.dispatch('relatorios/relatorio', { relatorio: 'contas-receber', data: data })
        .then(() => {
          this.showContent = true
        })
    },
    imprimir () {
      window.print()
    },
    exportar () {
      const data = Object.assign({}, this.data)
      if (data.data_vencimento_inicial) {
        data.data_vencimento_inicial = date.formatDate(data.data_vencimento_inicial, 'YYYY-MM-DD')
      }
      if (data.data_vencimento_final) {
        data.data_vencimento_final = date.formatDate(data.data_vencimento_final, 'YYYY-MM-DD')
      }
      if (data.data_pagamento_inicial) {
        data.data_pagamento_inicial = date.formatDate(data.data_pagamento_inicial, 'YYYY-MM-DD')
      }
      if (data.data_pagamento_final) {
        data.data_pagamento_final = date.formatDate(data.data_pagamento_final, 'YYYY-MM-DD')
      }
      if (data.data_lancamento_inicial) {
        data.data_lancamento_inicial = date.formatDate(data.data_lancamento_inicial, 'YYYY-MM-DD')
      }
      if (data.data_lancamento_final) {
        data.data_lancamento_final = date.formatDate(data.data_lancamento_final, 'YYYY-MM-DD')
      }
      this.$store.dispatch('relatorios/csv', { relatorio: 'contas-receber-csv', data: data })
        .then(() => {
          const url = `${process.env.DATA_URL}api/download/contar-receber/csv/${this.arqCsv}`
          let link = document.createElement('a')
          link.href = url
          link.click()
        })
    },
    status (status) {
      return this.$store.state.contasPagar.status[status]
    }
  },
  computed: {
    empresas () {
      const options = _.orderBy(this.$store.state.empresas.list.map(
        data =>
          ({
            label: data.razao_social,
            value: data.id
          })
      ), 'label', 'ASC')
      options.unshift({
        label: 'Todas',
        value: ''
      })

      return options
    },
    clientes () {
      const options = _.orderBy(this.$store.state.clientes.list.map(
        data =>
          ({
            label: data.razao_social,
            value: data.id
          })
      ), 'label', 'ASC')
      options.unshift({
        label: 'Todos',
        value: ''
      })
      return options
    },
    formasPagamento () {
      const options = _.orderBy(this.$store.state.formasPagamento.list.map(
        data =>
          ({
            label: data.banco.banco + ' - ' + data.forma_pagamento,
            value: data.id
          })
      ), 'label', 'ASC')
      options.unshift({
        label: 'Todos',
        value: ''
      })
      return options
    },
    statusOptions () {
      const options = this.$store.state.contasReceber.statusOptions
      options.unshift({
        label: 'Todos',
        value: ''
      })
      return options
    },
    ordenacao () {
      return [
        {
          label: 'Data de Pagamento',
          value: 'data_pagamento'
        },
        {
          label: 'Data de Vencimento',
          value: 'data_vencimento'
        },
        {
          label: 'Forma de Pagamento',
          value: 'forma_pagamento.forma_pagamento'
        },
        {
          label: 'Empresa',
          value: 'empresa.razao_social'
        },
        {
          label: 'Cliente',
          value: 'orcamento.cliente.razao_social'
        }
      ]
    },
    direcaoOrdenacao () {
      return [
        {
          label: 'Crescente',
          value: 'asc'
        },
        {
          label: 'Decrescente',
          value: 'desc'
        }
      ]
    },
    content () {
      return _.orderBy(this.$store.state.relatorios.content, this.order.campo, this.order.direcao)
    },
    loading () {
      return this.$store.state.relatorios.loading
    },
    arqCsv () {
      return this.$store.state.relatorios.arqCsv
    }
  },
  mounted () {
    this.getData()
  }
}
</script>

<style>
</style>
