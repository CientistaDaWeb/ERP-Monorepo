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
      card-class="bg-blue-2 text-brown"
      table-class="bg-blue-2"
      table-header-class="bg-blue-3"
    >
      <template
        slot="top-left"
      >
        <q-btn-group outline>
          <q-btn
            color="red-3"
            @click="deleteItem"
            icon="fa fa-trash"
            :label="module.btn.del"
          />
        </q-btn-group>
      </template>
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
        <q-tr :props="props">
          <q-td auto-width>
            <q-checkbox
              checked-icon="fa fa-trash"
              v-model="props.selected"
            >
              <q-tooltip
                content-class="bg-red"
                content-style="font-size: 12px"
              >
                Excluir Contrato
              </q-tooltip>
            </q-checkbox>
          </q-td>
          <q-td
            key="options"
            auto-width
          >
            <q-btn-group flat>
              <q-btn
                @click="$router.push({name:'contratos.editar', params: {id: props.row.id }})"
                icon="fa fa-edit"
                size="sm"
                color="#bbd3df"
                text-color="blue-9"
              >
                <q-tooltip
                  content-class="bg-indigo"
                  content-style="font-size: 12px"
                >
                  {{ module.btn.edit }}
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
            key="cliente"
            :props="props"
          >
            {{ props.row.orcamento.cliente.razao_social }}
          </q-td>
          <q-td
            key="data_assinatura"
            :props="props"
          >
            {{ props.row.data_assinatura | formatDate('DD/MM/YYYY') }}
          </q-td>
          <q-td
            key="data_encerramento"
            :props="props"
          >
            {{ props.row.data_encerramento | formatDate('DD/MM/YYYY') }}
          </q-td>
          <q-td
            key="empresa"
            :props="props"
          >
            {{ props.row.orcamento.empresa.razao_social }}
          </q-td>
          <q-td
            key="servico_contratado"
            :props="props"
          >
            {{ props.row.servico_contratado }}
          </q-td>
          <q-td
            key="valor_transporte"
            :props="props"
          >
            {{ props.row.valor_transporte | currency }}
          </q-td>
          <q-td
            key="valor_tratamento"
            :props="props"
          >
            {{ props.row.valor_tratamento | currency }}
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
  QTable,
  QInput,
  QIcon,
  QCheckbox
} from 'quasar'

export default {
  components: {
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
  name: 'ContratosDatatable',
  data: () => ({
    selected: [],
    pagination: {
      sortBy: 'data_assinatura',
      descending: false,
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
        name: 'orcamento',
        label: 'Orçamento',
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
        name: 'data_assinatura',
        label: 'Data de Assinatura',
        align: 'left',
        sortable: false
      },
      {
        name: 'data_encerramento',
        label: 'Data de Encerramento',
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
        name: 'servico_contratado',
        label: 'Serviço Contratado',
        align: 'left',
        sortable: false
      },
      {
        name: 'valor_transporte',
        label: 'Valor Trans.',
        align: 'right',
        sortable: false,
        style: 'width: 120px'
      },
      {
        name: 'valor_tratamento',
        label: 'Valor Trat. (m³)',
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
              this.$store.dispatch('contratos/deleteItem', id)
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
      this.$store.dispatch('contratos/searchList', payload)
        .then((data) => {
          this.pagination = data
        })
    }
  },
  computed: {
    list () {
      return this.$store.state.contratos.list
    },
    loading: {
      get () {
        return this.$store.state.contratos.loading
      },
      set (value) {
        this.$store.commit('contratos/setLoading', value)
      }
    },
    filter: {
      get () {
        return this.$store.state.contratos.filter
      },
      set (value) {
        this.$store.commit('contratos/setFilter', value)
      }
    },
    module () {
      return this.$store.state.contratos.module
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
<style lang="sass">
.table td
    white-space: nowrap !important

.table
  height: 580px
  width: 1000px !important

  td:first-child
    background-color: #bbd3df !important
    height: 10px
    width: 450px

  td:nth-child(2)
    background-color: #bbd3df !important
    height: 10px
    width: 10px  !important
    font-size: 10px
</style>
