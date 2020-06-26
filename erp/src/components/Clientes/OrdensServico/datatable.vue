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
      class="table"
      color="primary"
    >
      <template
        slot="body"
        slot-scope="props"
      >
        <q-tr
          :props="props"
          :class="color(props.row.status)"
        >
          <q-td
            key="options"
            auto-width
          >
            <q-btn-group flat>
              <q-btn
                @click="$router.push({name:'ordens-servico.editar', params: {id: props.row.id, cliente_id: this.cliente_id }})"
                icon="fa fa-edit"
                size="sm"
                color="primary"
                glossy
              >
                <q-tooltip>
                  {{ module.btn.edit }}
                </q-tooltip>
              </q-btn>
            </q-btn-group>
          </q-td>
          <q-td
            key="codigo"
            :props="props"
          >
            {{ props.row.codigo }}
          </q-td>
          <q-td
            key="data"
            :props="props"
          >
            {{ props.row.data_coleta | formatDate('DD/MM/YYYY') }}
          </q-td>
          <q-td
            key="empresa"
            :props="props"
          >
            {{ props.row.empresa.razao_social }}
          </q-td>
          <q-td
            key="valor"
            :props="props"
          >
            {{ props.row.valor | currency }}
          </q-td>
          <q-td
            key="desconto"
            :props="props"
          >
            {{ props.row.desconto | currency }}
          </q-td>
          <q-td
            key="total"
            :props="props"
          >
            {{ (props.row.valor - props.row.desconto) | currency }}
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
    clienteId: {
      type: Number,
      required: true
    }
  },
  name: 'ClientesOrdensServicoDatatable',
  data: () => ({
    selected: [],
    pagination: {
      sortBy: 'id',
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
        name: 'data',
        label: 'Data',
        align: 'center',
        sortable: false
      },
      {
        name: 'empresa',
        label: 'Empresa',
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
        name: 'desconto',
        label: 'Desconto',
        align: 'right',
        sortable: false,
        style: 'width: 120px'
      },
      {
        name: 'total',
        label: 'Total',
        align: 'right',
        sortable: false,
        style: 'width: 120px'
      }
    ]
  }),
  methods: {
    deleteItem () {
      if (this.selected.length > 0) {
        this.$q.dialog(
          {
            title: this.module.btn.del,
            message: 'Deseja excluir esses ' + this.module.plural + '?',
            ok: 'Sim, tenho certeza',
            cancel: 'Não'
          })
          .then(() => {
            let id = ''
            for (var i = 0; i < this.selected.length; i++) {
              id = this.selected[i]['id']
              this.$store.dispatch('ordensServico/deleteItem', id)
                .then(() => {
                  this.searchList({
                    pagination: this.pagination,
                    filter: this.filter
                  })
                })
            }
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
          cliente_id: this.cliente_id
        }
      }
      this.$store.dispatch('ordensServico/searchList', payload)
        .then((data) => {
          this.pagination = data
        })
    },
    color (status) {
      return this.$store.state.ordensServico.colors[status]
    }
  },
  computed: {
    list () {
      return this.$store.state.ordensServico.list
    },
    loading: {
      get () {
        return this.$store.state.ordensServico.loading
      },
      set (value) {
        this.$store.commit('ordensServico/setLoading', value)
      }
    },
    filter: {
      get () {
        return this.$store.state.ordensServico.filter
      },
      set (value) {
        this.$store.commit('ordensServico/setFilter', value)
      }
    },
    module () {
      return this.$store.state.ordensServico.module
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
