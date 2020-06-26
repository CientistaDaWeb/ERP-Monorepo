<template>
  <div class="row q-col-gutter-md">
    <div class="col-sm-12">
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
        class="table table-default"
      >
        <template
          slot="top-left"
        >
          <q-btn-group outline>
            <q-btn
              color="positive"
              @click="$router.push({name:'clientes-telefones.novo', params: {cliente_id: cliente_id}})"
              icon="fa fa-plus-circle"
              glossy
              label="Novo Telefone"
            />
            <q-btn
              color="negative"
              @click="deleteItem"
              icon="fa fa-trash"
              glossy
              label="Excluir Telefones"
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
                  @click="$router.push({name:'clientes-telefones.editar', params: {id: props.row.id, cliente_id: cliente_id }})"
                  icon="fa fa-edit"
                  size="sm"
                  color="primary"
                  glossy
                >
                  <q-tooltip>
                    Editar Telefone
                  </q-tooltip>
                </q-btn>
              </q-btn-group>
            </q-td>
            <q-td
              key="categoria"
              :props="props"
            >
              {{ props.row.categoria.categoria }}
            </q-td>
            <q-td
              key="contato"
              :props="props"
            >
              {{ props.row.contato }}
            </q-td>
            <q-td
              key="email"
              :props="props"
            >
              {{ props.row.email }}
            </q-td>
            <q-td
              key="telefone"
              :props="props"
            >
              <p v-html="$options.filters.formatPhone(props.row.telefone)" />
            </q-td>
          </q-tr>
        </template>
      </q-table>
    </div>
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
  name: 'ClientesTelefonesDatatable',
  props: {
    clienteId: {
      type: Number,
      required: true
    }
  },
  data: () => ({
    selected: [],
    filter: '',
    pagination: {
      sortBy: 'id',
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
        name: 'categoria',
        label: 'Categoria',
        align: 'left',
        sortable: true
      },
      {
        name: 'contato',
        label: 'Contato',
        align: 'left',
        sortable: true
      },
      {
        name: 'email',
        label: 'Email',
        align: 'left',
        sortable: true
      },
      {
        name: 'telefone',
        label: 'Telefone',
        align: 'left',
        sortable: true
      }
    ]
  }),
  methods: {
    deleteItem () {
      if (this.selected.length > 0) {
        this.$q.dialog(
          {
            title: 'Excluir Endereço',
            message: 'Deseja excluir esses registros?',
            ok: 'Sim, tenho certeza',
            cancel: 'Não'
          })
          .then(() => {
            let id = ''
            console.log(this.selected)
            for (var i = 0; i < this.selected.length; i++) {
              id = this.selected[i]['id']
              this.$store.dispatch('clientesTelefones/deleteItem', id)
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
      payload.where = {
        cliente_id: this.cliente_id
      }
      this.$store.dispatch('clientesTelefones/searchList', payload)
        .then((data) => {
          this.pagination = data
        })
    }
  },
  computed: {
    list () {
      return this.$store.state.clientesTelefones.list
    },
    loading: {
      get () {
        return this.$store.state.clientesTelefones.loading
      },
      set (value) {
        this.$store.commit('clientesTelefones/setLoading', value)
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
