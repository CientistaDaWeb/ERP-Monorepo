<template>
  <div>
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
      class="table"
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
            auto-width
          >
            <q-btn-group flat>
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
                @click="$router.push({name:'contas-receber.baixar', params: {id: props.row.id }})"
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
            key="orcamento"
            :props="props"
          >
            {{ props.row.orcamento.id }}
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
  </div>
</template>
<script>
import {
  QBtn,
  QBtnGroup,
  QTooltip,
  QTd,
  QTr,
  QTable
} from 'quasar'

export default {
  components: {
    QBtn,
    QBtnGroup,
    QTooltip,
    QTd,
    QTr,
    QTable
  },
  props: {

  },
  name: 'ClientesContasReceberDatatable',
  data: () => ({
    selected: [],
    pagination: {
      sortBy: 'data_vencimento',
      descending: true,
      page: 1,
      rowsNumber: 1,
      rowsPerPage: 0
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
        name: 'orcamento',
        label: 'Orçamento',
        align: 'center',
        sortable: false
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
    deleteItem () {
      if (this.selected.length > 0) {
        this.$q.dialog(
          {
            title: 'Excluir Conta a Receber',
            message: 'Deseja excluir esses registros?',
            ok: 'Sim, tenho certeza',
            cancel: 'Não'
          })
          .then(() => {
            let id = ''
            for (var i = 0; i < this.selected.length; i++) {
              id = this.selected[i]['id']
              this.$store.dispatch('contasReceber/deleteItem', id)
                .then(() => {
                  this.searchList({
                    pagination: this.pagination,
                    filter: this.filter
                  })
                })
            }
            this.selected = []
          })
          .catch(error => {
            console.log(error)
            this.$q.notify({
              message: 'Ação cancelada',
              color: 'info',
              icon: 'fa fa-check-circle'
            })
            this.selected = []
          })
      } else {
        this.$q.notify({
          message: 'Nenhum registro selecionado',
          color: 'negative',
          icon: 'fa fa-ban'
        })
      }
    },
    searchList (payload) {
      payload.whereHas = {
        orcamento: {
          cliente_id: this.$route.params.id
        }
      }
      this.$store.dispatch('contasReceber/searchList', payload)
        .then((data) => {
          this.pagination = data
        })
    },
    status (status) {
      return this.$store.state.contasReceber.status[status]
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
    }
  },
  mounted () {
    this.searchList(
      {
        pagination: this.pagination,
        filter: this.filter
      }
    )
  }
}
</script>
