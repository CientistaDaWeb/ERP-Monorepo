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
            @click="$router.push({name:'clientes.novo'})"
            icon="fa fa-plus-circle"
            glossy
            label="Novo Cliente"
          />
          <q-btn
            color="negative"
            @click="deleteItem"
            icon="fa fa-trash"
            glossy
            label="Excluir Clientes"
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
                @click="$router.push({name:'clientes.editar', params: {id: props.row.id }})"
                icon="fa fa-edit"
                size="sm"
                color="primary"
                glossy
              >
                <q-tooltip>
                  Editar Cliente
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
            key="razao_social"
            :props="props"
          >
            {{ props.row.razao_social }}
          </q-td>
          <q-td
            key="contato"
            :props="props"
          >
            {{ props.row.contato }}
          </q-td>
          <q-td
            key="categoria"
            :props="props"
          >
            {{ props.row.categoria.categoria }}
          </q-td>
          <q-td
            key="telefones"
            :props="props"
          >
            <p v-html="$options.filters.formatPhones(props.row.telefones)" />
          </q-td>
          <q-td
            key="enderecos"
            :props="props"
          >
            {{ props.row.enderecosCount }}
          </q-td>
          <q-td
            key="orcamentos"
            :props="props"
          >
            {{ props.row.orcamentosCount }}
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
  name: 'ClientesDatatable',
  data: () => ({
    selected: [],
    pagination: {
      sortBy: 'razao_social',
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
        name: 'razao_social',
        label: 'Razão Social',
        align: 'left',
        sortable: false
      },
      {
        name: 'contato',
        label: 'Contato',
        align: 'left',
        sortable: false
      },
      {
        name: 'categoria',
        label: 'Categoria',
        align: 'left',
        sortable: false
      },
      {
        name: 'telefones',
        label: 'Telefones',
        align: 'left',
        sortable: false
      },
      {
        name: 'enderecos',
        label: 'Nº End.',
        align: 'center',
        sortable: false
      },
      {
        name: 'orcamentos',
        label: 'Nº Orc.',
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
            title: 'Excluir Clientes',
            message: 'Deseja excluir esses registros?',
            ok: 'Sim, tenho certeza',
            cancel: 'Não'
          })
          .then(() => {
            let id = ''
            for (var i = 0; i < this.selected.length; i++) {
              id = this.selected[i]['id']
              this.$store.dispatch('clientes/deleteItem', id)
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
      this.$store.dispatch('clientes/searchList', payload)
        .then((data) => {
          this.pagination = data
        })
    }
  },
  computed: {
    list () {
      return this.$store.state.clientes.list
    },
    loading: {
      get () {
        return this.$store.state.clientes.loading
      },
      set (value) {
        this.$store.commit('clientes/setLoading', value)
      }
    },
    filter: {
      get () {
        return this.$store.state.clientes.filter
      },
      set (value) {
        this.$store.commit('clientes/setFilter', value)
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
