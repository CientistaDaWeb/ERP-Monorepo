<template>
  <div>
    <q-banner
      class="q-mb-md bg-warning text-white"
      v-if="orcamento.cliente"
    >
      <nl2br
        tag="p"
        :text="orcamento.cliente.observacoes_faturamento"
      />
    </q-banner>
    <table class="table q-table q-mb-md">
      <tbody>
        <tr>
          <td align="right">
            <b>Total a Receber</b>
          </td>
          <td align="right">
            {{ totalReceber | currency }}
          </td>
          <td align="right">
            <b>Total Recebido</b>
          </td>
          <td align="right">
            {{ totalRecebido | currency }}
          </td>
          <td align="right">
            <b>Total</b>
          </td>
          <td
            align="right"
            :class="(total < 0)? 'error' : ''"
          >
            {{ total | currency }}
          </td>
        </tr>
      </tbody>
    </table>
    <q-table
      :loading="loading"
      :data="list"
      :columns="columns"
      :pagination.sync="pagination"
      row-key="id"
      :filter="filter"
      @request="searchList"
      class="table q-mb-md"
      color="primary"
    >
      <template
        slot="body"
        slot-scope="props"
      >
        <q-tr
          :props="props"
          :class="status(props.row.status)"
        >
          <q-td
            key="options"
            align="center"
            auto-width
          >
            <q-btn-group flat>
              <q-btn
                @click="deleteItem(props.row.id)"
                icon="fa fa-trash"
                size="sm"
                color="negative"
                glossy
              >
                <q-tooltip>
                  Excluir Conta a Receber
                </q-tooltip>
              </q-btn>
              <q-btn
                @click="$router.push({name:'contas-receber.editar', params: {id: props.row.id }})"
                icon="fa fa-edit"
                size="sm"
                color="primary"
                glossy
              >
                <q-tooltip>
                  Editar Conta a Receber
                </q-tooltip>
              </q-btn>
              <q-btn
                v-if="props.row.status !== 'pago'"
                @click="abrirModal(props.row.id)"
                icon="fa fa-money-bill-wave"
                size="sm"
                color="primary"
                glossy
              >
                <q-tooltip>
                  Dar Baixa em Conta a Receber
                </q-tooltip>
              </q-btn>
            </q-btn-group>
          </q-td>
          <q-td
            key="codigo"
            :props="props"
          >
            {{ props.row.id }}
          </q-td>
          <q-td
            key="data_vencimento"
            :props="props"
          >
            {{ props.row.data_vencimento | formatDate('DD/MM/YYYY') }}
          </q-td>
          <q-td
            key="valor"
            :props="props"
          >
            {{ props.row.valor - props.row.valor_retido | currency }}
          </q-td>
          <q-td
            key="data_pagamento"
            :props="props"
          >
            {{ props.row.data_pagamento | formatDate('DD/MM/YYYY') }}
          </q-td>
          <q-td
            key="valor_pago"
            :props="props"
          >
            {{ props.row.valor_pago | currency }}
          </q-td>
          <q-td
            key="cte"
            :props="props"
          >
            ???
          </q-td>
        </q-tr>
      </template>
    </q-table>
    <q-card
      class="q-mb-md"
    >
      <q-card-section>
        <div
          class="text-h6 bg-secondary q-pa-md"
        >
          Gerar Faturas
        </div>
      </q-card-section>
      <q-card-section>
        <div class="row q-col-gutter-md">
          <div
            class="col col-sm-12 col-xs-12"
            v-if="ordensServico.length"
          >
            <p class="q-pa-sm q-mt-md bg-primary text-white">
              Ordens de Serviço
            </p>
            <div class="row q-col-gutter-md">
              <div
                class="col col-sm-2 col-xs-12"
                v-for="item in ordensServico"
                :key="item.id"
              >
                <q-checkbox
                  :label="item.codigo"
                  v-model="os"
                  :val="item.id"
                />
              </div>
              <div class="col col-sm-12 col-xs-12">
                <hr>
              </div>
            </div>
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-input
              prefix="R$"
              v-model="model.valor"
              label="Valor Total"
              data-vv-name="Valor Total"
              v-validate="'required'"
              :error="errors.has('Valor Total')"
              :error-message="errors.first('Valor Total')"
            />
          </div>
          <div class="col col-sm-2 col-xs-12">
            <q-select
              :options="parcelas"
              v-model="model.parcelas"
              label="Parcelas"
              data-vv-name="Parcelas"
              v-validate="'required'"
              :error="errors.has('Parcelas')"
              :error-message="errors.first('Parcelas')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-select
              :options="periodicidades"
              v-model="model.periodicidade"
              label="Periodicidade"
              data-vv-name="Periodicidade"
              v-validate="'required'"
              :error="errors.has('Periodicidade')"
              :error-message="errors.first('Periodicidade')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12 self-center text-right">
            <q-btn
              color="positive"
              icon="fa fa-plus-circle"
              glossy
              label="Gerar Faturas"
              :loading="submitting"
              @click="gerarFaturas"
            />
          </div>
        </div>
      </q-card-section>
    </q-card>
    <q-card v-if="faturas.length">
      <q-card-section>
        <div class="text-h6 bg-blue-curacao">
          Faturas - Confira os dados
        </div>
      </q-card-section>
      <q-card-section>
        <form @submit.prevent="save">
          <div class="row q-col-gutter-md">
            <div class="col col-sm-6 col-xs-12">
              <q-select
                filter
                :options="empresas"
                v-model="model.empresa_id"
                label="Empresa"
                data-vv-name="Empresa"
                v-validate="'required'"
                :error="errors.has('Empresa')"
                :error-message="errors.first('Empresa')"
              />
            </div>
            <div class="col col-sm-6 col-xs-12">
              <q-select
                filter
                :options="formasPagamento"
                v-model="model.forma_pagamento_id"
                label="Forma de Pagamento"
                data-vv-name="Forma de Pagamento"
                v-validate="'required'"
                :error="errors.has('Forma de Pagamento')"
                :error-message="errors.first('Forma de Pagamento')"
              />
            </div>
            <div class="col col-sm-6 col-xs-12">
              <q-select
                filter
                :options="enderecos"
                v-model="model.endereco_id"
                label="Endereço"
                data-vv-name="Endereço"
                v-validate="'required'"
                :error="errors.has('Endereço')"
                :error-message="errors.first('Endereço')"
              />
            </div>
            <div class="col col-sm-6 col-xs-12">
              <q-input
                v-model="model.descricao"
                label="Descrição"
              />
            </div>
            <div class="col col-sm-12 col-xs-12">
              <q-input
                type="textarea"
                rows="3"
                v-model="model.observacoes"
                label="Observações"
              />
            </div>
            <div class="col col-sm-12 col-xs-12">
              <p class="q-pa-sm bg-primary text-white">
                Parcelas
              </p>
              <div
                class="row q-col-gutter-md"
                v-for="item in faturas"
                :key="item.id"
              >
                <div class="col col-sm-4 col-xs-12">
                  <q-input
                    ref="data_emissao"
                    v-model="model.data"
                    label="Data do Vencimento"
                    data-vv-name="Data do Vencimento"
                    :error="errors.has('Data do Vencimento')"
                    :error-message="errors.first('Data do Vencimento')"
                    :rules="[val => !!val || 'Data Vencimento Requerida']"
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
                            v-model="model.data"
                          />
                        </q-popup-proxy>
                      </q-icon>
                    </template>
                  </q-input>
                </div>
                <div class="col col-sm-4 col-xs-12">
                  <q-input
                    prefix="R$"
                    v-model="model.item_valor"
                    label="Valor"
                    data-vv-name="Valor"
                    v-validate="'required'"
                    :error="errors.has('Valor')"
                    :error-message="errors.first('Valor')"
                  />
                </div>
                <div class="col col-sm-4 col-xs-12">
                  <q-input
                    prefix="R$"
                    v-model="model.item_valor_retido"
                    label="Valor Retido"
                    data-vv-name="Valor Retido"
                    v-validate="'required'"
                    :error="errors.has('Valor Retido')"
                    :error-message="errors.first('Valor Retido')"
                  />
                </div>
              </div>
            </div>
            <div class="col col-sm-12 col-xs-12 self-center text-right">
              <q-btn
                color="positive"
                icon="fa fa-plus-circle"
                glossy
                label="Salvar Faturas"
                :loading="submitting"
                type="submit"
              />
            </div>
          </div>
        </form>
      </q-card-section>
    </q-card>
    <ContasReceberBaixar
      ref="contasReceberBaixar"
    />
  </div>
</template>
<script>
import {
  date,
  QBtn,
  QBtnGroup,
  QTooltip,
  QTd,
  QTr,
  QTable,
  QCheckbox,
  QCard,
  QCardSection,
  QSelect,
  QInput,
  QBanner,
  QDate,
  QPopupProxy
} from 'quasar'
import _ from 'lodash'
import Nl2br from 'vue-nl2br'
import ContasReceberBaixar from '../../ContasReceber/baixar'

const { addToDate } = date

export default {
  components: {
    ContasReceberBaixar,
    QBtn,
    QBtnGroup,
    QTooltip,
    QTd,
    QTr,
    QTable,
    QCheckbox,
    QCard,
    QCardSection,
    QSelect,
    QInput,
    QBanner,
    QDate,
    QPopupProxy,
    Nl2br
  },
  props: {
    orcamentoId: {
      type: Number,
      required: true
    }
  },
  name: 'OrcamentosContasReceberDatatable',
  data: () => ({
    selected: [],
    pagination: {
      sortBy: 'data_vencimento',
      descending: true,
      page: 1,
      rowsNumber: 1,
      rowsPerPage: 0
    },
    os: [],
    model: {
      valor: '0',
      parcelas: 1,
      periodicidade: 'Mensal',
      empresa_id: '',
      forma_pagamento_id: '',
      endereco_id: '',
      descricao: '',
      observacoes: '',
      data: '',
      item_valor: '',
      item_valor_retido: ''
    },
    submitting: false,
    faturas: [],
    columns: [
      {
        name: 'options'
      },
      {
        name: 'codigo',
        label: 'Código',
        align: 'center',
        sortable: false,
        style: 'width: 90px'
      },
      {
        name: 'data_vencimento',
        label: 'Data de Vencimento',
        align: 'center',
        sortable: false
      },
      {
        name: 'valor',
        label: 'Valor',
        align: 'right',
        sortable: false,
        style: 'width: 120px'
      },
      {
        name: 'data_pagamento',
        label: 'Data de Pagamento',
        align: 'center',
        sortable: false
      },
      {
        name: 'valor_pago',
        label: 'Valor Pago',
        align: 'right',
        sortable: false,
        style: 'width: 120px'
      },
      {
        name: 'cte',
        label: 'CT-e',
        align: 'center',
        sortable: false
      }
    ]
  }),
  methods: {
    getData () {
      this.$store.dispatch('empresas/loadList', {})
      this.$store.dispatch('formasPagamento/loadList', {})
      this.$store.dispatch('clientesEnderecos/loadList', {
        where: {
          cliente_id: this.orcamento.cliente_id
        }
      })
      this.$store.dispatch('ordensServico/loadList', {
        where: {
          orcamento_id: this.orcamento_id,
          faturado: 'N'
        }
      })
    },
    deleteItem (id) {
      this.$q.dialog(
        {
          title: this.module.btn.del,
          message: 'Deseja excluir essa ' + this.module.singular + '?',
          ok: 'Sim, tenho certeza',
          cancel: 'Não'
        })
        .then(() => {
          this.$store.dispatch('contasReceber/deleteItem', id)
            .then(() => {
              this.searchList({
                pagination: this.pagination,
                filter: this.filter
              })
            })
        })
    },
    searchList (payload) {
      payload.where = {
        orcamento_id: this.orcamento_id
      }
      this.$store.dispatch('contasReceber/searchList', payload)
        .then((data) => {
          this.pagination = data
        })
    },
    status (status) {
      return this.$store.state.contasReceber.status[status]
    },
    abrirModal (id) {
      this.$refs.contasReceberBaixar.abrirModal(id)
    },
    gerarFaturas () {
      this.faturas = []
      let data = Date.now()
      const valorParcela = (this.model.valor / this.model.parcelas).toFixed(2)
      for (let i = 0; i < this.model.parcelas; i++) {
        data = addToDate(data, { days: this.model.periodicidade })
        this.faturas[i] = {
          id: i,
          data: data,
          valor: valorParcela,
          valor_retido: 0
        }
        if (i === (this.model.parcelas - 1)) {
          this.faturas[i].valor = (this.model.valor - (valorParcela * (this.model.parcelas - 1))).toFixed(2)
        }
      }
    },
    save () {
      this.$validator.validate()
        .then(result => {
          if (!result) {
            this.$q.notify({
              message: 'O registro não foi salvo, verifique os campos incorretos.',
              icon: 'fa fa-exclamation-triangle'
            })
          } else {
            // this.submitting = true
            let data = {
              os: this.model.os,
              orcamento_id: this.orcamentoId,
              empresa_id: this.model.empresa_id.value,
              forma_pagamento_id: this.model.forma_pagamento_id.value,
              endereco_id: this.model.endereco_id.value,
              descricao: this.model.descricao,
              observacoes: this.model.observacoes,
              parcelas: this.model.parcelas
            }
            console.log(data)
            this.$store.dispatch('contasReceber/salvaFaturas', data)
              .then(() => {
                this.searchList({
                  pagination: this.pagination,
                  filter: this.filter
                })
                this.getData()
              })
            this.model = {}
            this.faturas = []
            this.os = []
            this.$validator.reset()
            // this.submitting = false
          }
        })
    }
  },
  computed: {
    list () {
      return this.$store.state.contasReceber.list
    },
    loading: {
      get () {
        return this.$store.state.contasReceber.loading
      },
      set (value) {
        this.$store.commit('contasReceber/setLoading', value)
      }
    },
    filter: {
      get () {
        return this.$store.state.contasReceber.filter
      },
      set (value) {
        this.$store.commit('contasReceber/setFilter', value)
      }
    },
    totalReceber () {
      if (!this.list) {
        return 0
      }
      return this.list.reduce(function (total, value) {
        return total + Number(value.valor) - Number(value.valor_retido)
      }, 0)
    },
    totalRecebido () {
      if (!this.list) {
        return 0
      }
      return this.list.reduce(function (total, value) {
        return total + Number(value.valor_pago)
      }, 0)
    },
    total () {
      return this.totalRecebido - this.totalReceber
    },
    module () {
      return this.$store.state.contasReceber.module
    },
    periodicidades () {
      return this.$store.state.contasReceber.periodicidades
    },
    parcelas () {
      return this.$store.state.contasReceber.parcelas
    },
    orcamento () {
      return this.$store.state.orcamentos.item
    },
    ordensServico () {
      return this.$store.state.ordensServico.list
    },
    empresas () {
      return _.orderBy(this.$store.state.empresas.list.map(
        data =>
          ({
            label: data.razao_social,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    formasPagamento () {
      return _.orderBy(this.$store.state.formasPagamento.list.map(
        data =>
          ({
            label: data.banco.banco + ' - ' + data.forma_pagamento,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    enderecos () {
      return _.orderBy(this.$store.state.clientesEnderecos.list.map(
        data =>
          ({
            label: data.endereco,
            value: data.id
          })
      ), 'label', 'ASC')
    }
  },
  mounted () {
    this.searchList(
      {
        pagination: this.pagination,
        filter: this.filter
      }
    )
    this.getData()
    console.log(this.orcamento)
  }
}
</script>
