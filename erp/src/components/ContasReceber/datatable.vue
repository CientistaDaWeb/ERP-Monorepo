<template>
  <div>
    <q-table
      :loading="loading"
      :data="list"
      :columns="columns"
      :pagination.sync="pagination"
      row-key="id"
      :filter="filter"
      @request="searchList"
      selection="multiple"
      :selected.sync="selected"
      class="table"
      color="primary"
    >
      <template
        slot="top-right"
      >
        <q-input
          borderless
          dense
          debounce="300"
          v-model="filter"
          placeholder="Buscar"
        >
          <template v-slot:append>
            <q-icon name="fa fa-search" />
          </template>
        </q-input>
      </template>
      <template
        slot="body"
        slot-scope="props"
      >
        <q-tr
          :props="props"
          :class="status(props.row.status)"
        >
          <q-td auto-width>
            <q-checkbox
              checked-icon="fa fa-trash"
              v-model="props.selected"
            />
          </q-td>
          <q-td
            key="options"
            auto-width
            class="text-center"
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
            key="cliente"
            :props="props"
          >
            {{ props.row.orcamento.cliente.razao_social }}
          </q-td>
          <q-td
            key="valor"
            :props="props"
          >
            {{ props.row.valor | currency }}
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
            key="valor_retido"
            :props="props"
          >
            {{ props.row.valor_retido | currency }}
          </q-td>
          <q-td
            key="empresa"
            :props="props"
          >
            {{ props.row.empresa.razao_social }}
          </q-td>
          <q-td
            key="forma_pagamento"
            :props="props"
          >
            {{ props.row.forma_pagamento.forma_pagamento }}
          </q-td>
        </q-tr>
      </template>
    </q-table>
    <ContasReceberBaixar
      ref="contasReceberBaixar"
    />
  </div>
</template>
<script>
import {
  QBtn,
  QBtnGroup,
  QTooltip,
  QTd,
  QTr,
  QTable,
  QInput,
  QIcon,
  QCheckbox
} from 'quasar'
import ContasReceberBaixar from './baixar'

export default {
  components: {
    ContasReceberBaixar,
    QBtn,
    QBtnGroup,
    QTooltip,
    QTd,
    QTr,
    QTable,
    QInput,
    QIcon,
    QCheckbox
  },
  name: 'ContasReceberDatatable',
  data: () => ({
    selected: [],
    pagination: {
      sortBy: 'data_vencimento',
      descending: true,
      page: 1,
      rowsNumber: 1,
      rowsPerPage: 10
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
        name: 'data_vencimento',
        label: 'Data de Vencimento',
        align: 'center',
        sortable: false
      },
      {
        name: 'cliente',
        label: 'Cliente',
        align: 'left',
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
        name: 'valor_retido',
        label: 'Valor Retido',
        align: 'right',
        sortable: false,
        style: 'width: 120px'
      },
      {
        name: 'empresa',
        label: 'Empresa',
        align: 'left',
        sortable: false
      },
      {
        name: 'forma_pagamento',
        label: 'Fprma de Pgamento',
        align: 'left',
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
