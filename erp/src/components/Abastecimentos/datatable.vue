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
        slot="top-left"
      >
        <q-btn-group outline>
          <q-btn
            color="positive"
            @click="$router.push({name:'abastecimentos.novo'})"
            icon="fa fa-plus-circle"
            glossy
            :label="module.btn.new"
          />
          <q-btn
            color="negative"
            @click="deleteItem"
            icon="fa fa-trash"
            glossy
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
            />
          </q-td>
          <q-td
            key="options"
            auto-width
          >
            <q-btn-group flat>
              <q-btn
                @click="$router.push({name:'abastecimentos.editar', params: {id: props.row.id }})"
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
            {{ props.row.id }}
          </q-td>
          <q-td
            key="data"
            :props="props"
          >
            {{ props.row.data | formatDate('DD/MM/YYYY') }}
          </q-td>
          <q-td
            key="aditivo"
            :props="props"
          >
            {{ props.row.aditivo.nome }}
          </q-td>
          <q-td
            key="litros"
            :props="props"
          >
            {{ props.row.litros }}
          </q-td>
          <q-td
            key="km"
            :props="props"
          >
            {{ props.row.km }}
          </q-td>
          <q-td
            key="media"
            :props="props"
          >
            {{ props.row.media }}
          </q-td>
          <q-td
            key="valor_litro"
            :props="props"
          >
            {{ props.row.valor_litro | currency }}
          </q-td>
          <q-td
            key="valor"
            :props="props"
          >
            {{ props.row.valor | currency }}
          </q-td>
          <q-td
            key="caminhao"
            :props="props"
          >
            {{ props.row.caminhao.placa }}
          </q-td>
          <q-td
            key="fornecedor"
            :props="props"
          >
            {{ formatFornecedor(props.row.fornecedor) }}
          </q-td>
        </q-tr>
      </template>
    </q-table>
  </div>
</template>
<script>
import {
  QInput,
  QBtn,
  QBtnGroup,
  QTooltip,
  QTd,
  QTr,
  QTable,
  QCheckbox,
  QIcon,
  date
} from 'quasar'

export default {
  components: {
    QInput,
    QBtn,
    QBtnGroup,
    QTooltip,
    QTd,
    QTr,
    QTable,
    QCheckbox,
    QIcon
  },
  name: 'AbastecimentosDatatable',
  data: () => ({
    selected: [],
    pagination: {
      sortBy: 'data',
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
        name: 'aditivo',
        label: 'Aditivo',
        align: 'left',
        sortable: false
      },
      {
        name: 'litros',
        label: 'Litros',
        align: 'left',
        sortable: false
      },
      {
        name: 'km',
        label: 'Km',
        align: 'left',
        sortable: false
      },
      {
        name: 'media',
        label: 'Média',
        align: 'left',
        sortable: false
      },
      {
        name: 'valor_litro',
        label: 'Valor/Litro',
        align: 'right',
        sortable: false,
        style: 'width: 120px'
      },
      {
        name: 'valor',
        label: 'Valor',
        align: 'right',
        sortable: false,
        style: 'width: 120px'
      },
      {
        name: 'caminhao',
        label: 'Caminhão',
        align: 'left',
        sortable: false
      },
      {
        name: 'fornecedor',
        label: 'Fornecedor',
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
            title: 'Excluir Abastecimentos',
            message: 'Deseja excluir esses ' + this.module.plural + '?',
            ok: 'Sim, tenho certeza',
            cancel: 'Não'
          })
          .then(() => {
            let id = ''
            for (var i = 0; i < this.selected.length; i++) {
              id = this.selected[i]['id']
              this.$store.dispatch('abastecimentos/deleteItem', id)
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
      this.$store.dispatch('abastecimentos/searchList', payload)
        .then((data) => {
          this.pagination = data
        })
    },
    formatDate (data) {
      return date.formatDate(data, 'DD/MM/YYYY')
    },
    formatFornecedor (fornecedor) {
      if (fornecedor) {
        return fornecedor.razao_social
      }
      return 'Não Informado'
    }
  },
  computed: {
    list () {
      return this.$store.state.abastecimentos.list
    },
    loading: {
      get () {
        return this.$store.state.abastecimentos.loading
      },
      set (value) {
        this.$store.commit('abastecimentos/setLoading', value)
      }
    },
    filter: {
      get () {
        return this.$store.state.abastecimentos.filter
      },
      set (value) {
        this.$store.commit('abastecimentos/setFilter', value)
      }
    },
    module () {
      return this.$store.state.abastecimentos.module
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
