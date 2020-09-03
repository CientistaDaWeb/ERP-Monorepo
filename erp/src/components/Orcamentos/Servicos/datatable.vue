<template>
  <div>
    <form @submit.prevent="save">
      <div class="row q-col-gutter-md q-mb-md">
        <div class="col col-sm-5 col-xs-12">
          <q-select
            ref="empresa_id"
            v-model="model.servico_id"
            :options="servicos"
            label="Serviço"
            emit-value
            map-options
          />
        </div>
        <div class="col col-sm-2 col-xs-12">
          <q-input
            type="number"
            v-model="model.qtde"
            label="Quantidade"
            data-vv-name="Quantidade"
            v-validate="'required'"
            :error="errors.has('Quantidade')"
            :error-message="errors.first('Quantidade')"
          />
        </div>
        <div class="col col-sm-2 col-xs-12">
          <!-- <q-input
              mask="#.##"
              fill-mask="0"
              reverse-fill-mask
              prefix="R$"
              v-model="model.valor_total"
              label="Valor Total"
              helper="caso tenha negociado um valor fechado"
            /> -->
          <q-input
            mask="#.##"
            fill-mask="0"
            prefix="R$"
            reverse-fill-mask
            v-model="model.preco"
            label="Valor Unitário"
            data-vv-name="Valor Unitário"
            v-validate="'required'"
            :error="errors.has('Valor Unitário')"
            :error-message="errors.first('Valor Unitário')"
          />
        </div>
        <div class="col col-sm-3 col-xs-12 self-center">
          <q-btn
            color="positive"
            icon="fa fa-plus-circle"
            glossy
            label="Adicionar Serviço"
            :loading="submitting"
            type="submit"
          />
        </div>
      </div>
    </form>
    <q-table
      :loading="loading"
      :data="list"
      :columns="columns"
      :pagination.sync="pagination"
      row-key="id"
      :filter="filter"
      @request="searchList"
      class="table"
      color="primary"
    >
      <template
        slot="body"
        slot-scope="props"
      >
        <q-tr :props="props">
          <q-td
            key="options"
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
                  Excluir Serviço
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
            key="servico"
            :props="props"
          >
            {{ props.row.servico.servico }}
          </q-td>
          <q-td
            key="categoria"
            :props="props"
          >
            {{ props.row.servico.categoria.categoria }}
          </q-td>
          <q-td
            key="qtde"
            :props="props"
          >
            {{ props.row.qtde }} {{ props.row.servico.unidade }}
          </q-td>
          <q-td
            key="preco"
            :props="props"
          >
            {{ props.row.preco | currency }}
          </q-td>
        </q-tr>
      </template>
    </q-table>
  </div>
</template>
<script>
import {
  QSelect,
  QBtn,
  QBtnGroup,
  QTooltip,
  QTd,
  QTr,
  QTable,
  QInput
} from 'quasar'
import _ from 'lodash'

export default {
  components: {
    QSelect,
    QBtn,
    QBtnGroup,
    QTooltip,
    QTd,
    QTr,
    QTable,
    QInput
  },
  props: {
    orcamentoId: {
      type: Number,
      required: true
    }
  },
  name: 'OrcamentosServicosDatatable',
  data: () => ({
    selected: [],
    pagination: {
      sortBy: 'id',
      descending: true,
      page: 1,
      rowsNumber: 1,
      rowsPerPage: 10
    },
    submitting: false,
    model: {
      servico_id: 1,
      qtde: 1,
      preco: 0
    },
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
        name: 'servico',
        label: 'Serviço',
        align: 'left',
        sortable: false
      },
      {
        name: 'qtde',
        label: 'Qtde',
        align: 'center',
        sortable: false
      },
      {
        name: 'preco',
        label: 'Valor Unitário',
        align: 'center',
        sortable: false
      }
    ]
  }),
  methods: {
    getData () {
      this.$store.dispatch('servicos/loadList', {})
    },
    completaValor (id) {
      if (id) {
        this.submitting = true
        this.$store.dispatch('servicos/loadItem', id)
          .then((data) => {
            this.model.preco = data.valor_unitario
            this.submitting = false
          })
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
            this.submitting = true
            let data = {
              servico_id: this.model.servico_id,
              orcamento_id: this.orcamentoId,
              qtde: this.model.qtde,
              preco: this.model.preco
            }
            this.$store.dispatch('orcamentosServicos/saveItem', data)
              .then(() => {
                this.searchList({
                  pagination: this.pagination,
                  filter: this.filter
                })
              })
            this.model = {
              servico_id: 1,
              qtde: 1,
              preco: 0
            }
            this.$validator.reset()
            this.submitting = false
          }
        })
    },
    deleteItem (id) {
      this.$q.dialog(
        {
          title: this.module.btn.del,
          message: 'Deseja excluir esse ' + this.module.singular + '?',
          ok: 'Sim, tenho certeza',
          cancel: 'Não'
        })
        .onOk(() => {
          console.log(id)
          this.$store.dispatch('orcamentosServicos/deleteItem', id)
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
        orcamento_id: this.orcamentoId
      }
      this.$store.dispatch('orcamentosServicos/searchList', payload)
        .then((data) => {
          this.pagination = data
        })
    }
  },
  computed: {
    list () {
      return this.$store.state.orcamentosServicos.list
    },
    loading: {
      get () {
        return this.$store.state.orcamentosServicos.loading
      },
      set (value) {
        this.$store.commit('orcamentosServicos/setLoading', value)
      }
    },
    filter: {
      get () {
        return this.$store.state.orcamentosServicos.filter
      },
      set (value) {
        this.$store.commit('orcamentosServicos/setFilter', value)
      }
    },
    module () {
      return this.$store.state.orcamentosServicos.module
    },
    servicos () {
      return _.orderBy(this.$store.state.servicos.list.map(
        data =>
          ({
            label: '[' + data.id + '] ' + data.servico,
            value: data.id,
            order: data.servico
          })
      ), 'order', 'ASC')
    }
  },
  mounted () {
    this.getData()
    this.searchList(
      {
        pagination: this.pagination,
        filter: this.filter
      }
    )
  }
}
</script>
