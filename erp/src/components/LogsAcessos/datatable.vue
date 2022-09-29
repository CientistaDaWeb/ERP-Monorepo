<template>
  <div>
    <q-table
      :data="list"
      :columns="columns"
      :pagination.sync="pagination"
      row-key="id"
      :filter="filter"
      @request="searchList"
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
                @click="$router.push({name:'estados.editar', params: {id: props.row.id }})"
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
            key="estado"
            :props="props"
          >
            {{ props.row.estado }}
          </q-td>
          <q-td
            key="uf"
            :props="props"
          >
            {{ props.row.uf }}
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
  name: 'LogAcessosDatatable',
  data: () => ({
    selected: [],
    pagination: {
      sortBy: 'data',
      descending: false,
      page: 1,
      rowsNumber: 1,
      rowsPerPage: 10
    },
    columns: [
      {
        name: 'data',
        label: 'Data',
        align: 'center',
        sortable: true
      },
      {
        name: 'usuario',
        label: 'Usuário',
        align: 'left',
        sortable: true
      },
      {
        name: 'ip',
        label: 'IP',
        align: 'Left',
        sortable: false
      },
      {
        name: 'navegador',
        label: 'Navegador',
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
            title: this.module.btn.del,
            message: 'Deseja excluir esses ' + this.module.plural + '?',
            ok: 'Sim, tenho certeza',
            cancel: 'Não'
          })
          .then(() => {
            let id = ''
            for (var i = 0; i < this.selected.length; i++) {
              id = this.selected[i]['id']
              this.$store.dispatch('estados/deleteItem', id)
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
      this.$store.dispatch('estados/searchList', payload)
        .then((data) => {
          this.pagination = data
        })
    }
  },
  computed: {
    list () {
      return this.$store.state.estados.list
    },
    loading: {
      get () {
        return this.$store.state.estados.loading
      },
      set (value) {
        this.$store.commit('estados/setLoading', value)
      }
    },
    filter: {
      get () {
        return this.$store.state.estados.filter
      },
      set (value) {
        this.$store.commit('estados/setFilter', value)
      }
    },
    module () {
      return this.$store.state.estados.module
    }
  },
  mounted () {
    // this.searchList(
    //   {
    //     pagination: this.pagination,
    //     filter: this.filter
    //   }
    // )
  }
}
</script>
