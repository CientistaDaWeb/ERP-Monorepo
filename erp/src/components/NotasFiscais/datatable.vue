<template>
  <div>
    <q-table
      :loading="loading"
      :data="list"
      :columns="columns"
      :pagination.sync="pagination"
      :filter="filter"
      row-key="id"
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
            color="negative"
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
            />
          </q-td>
          <q-td
            key="options"
            auto-width
          >
            <q-btn-group flat>
              <q-btn
                @click="$router.push({name:'notas-fiscais.editar', params: {id: props.row.id }})"
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
            key="numero"
            :props="props"
          >
            {{ props.row.numero }}
          </q-td>
          <q-td
            key="orcamento"
            :props="props"
          >
            {{ props.row.orcamento.id }}
          </q-td>
          <q-td
            key="data_geracao"
            :props="props"
          >
            {{ props.row.data_geracao | formatDate('DD/MM/YYYY') }}
          </q-td>
          <q-td
            key="cliente"
            :props="props"
          >
            {{ props.row.orcamento.cliente.razao_social }}
          </q-td>
          <q-td
            key="empresa"
            :props="props"
          >
            {{ props.row.empresa.razao_social }}
          </q-td>
          <q-td
            key="tipo"
            :props="props"
          >
            {{ props.row.tipoHumanized }}
          </q-td>
          <q-td
            key="valor"
            :props="props"
          >
            {{ props.row.valor | currency }}
          </q-td>
          <q-td
            key="valor_retido"
            :props="props"
          >
            {{ props.row.valor_retido | currency }}
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
  name: 'NotasFiscaisDatatable',
  data: () => ({
    selected: [],
    pagination: {
      sortBy: 'data_geracao',
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
        name: 'orcamento',
        label: 'Orçamento',
        align: 'center',
        sortable: false
      },
      {
        name: 'data_geracao',
        label: 'Data de Geração',
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
        name: 'empresa',
        label: 'Empresa',
        align: 'left',
        sortable: false
      },
      {
        name: 'tipo',
        label: 'Tipo',
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
        name: 'valor_retido',
        label: 'valor_retido',
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
          .onOk(() => {
            let id = ''
            for (var i = 0; i < this.selected.length; i++) {
              id = this.selected[i]['id']
              this.$store.dispatch('notasFiscais/deleteItem', id)
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
      this.$store.dispatch('notasFiscais/searchList', payload)
        .then((data) => {
          this.pagination = data
        })
    }
  },
  computed: {
    list () {
      return this.$store.state.notasFiscais.list
    },
    loading: {
      get () {
        return this.$store.state.notasFiscais.loading
      },
      set (value) {
        this.$store.commit('notasFiscais/setLoading', value)
      }
    },
    filter: {
      get () {
        return this.$store.state.notasFiscais.filter
      },
      set (value) {
        this.$store.commit('notasFiscais/setFilter', value)
      }
    },
    module () {
      return this.$store.state.notasFiscais.module
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
