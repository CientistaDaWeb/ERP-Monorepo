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
              @click="$router.push({name:'clientes-crm.novo', params: {cliente_id: $route.params.id}})"
              icon="fa fa-plus-circle"
              glossy
              label="Novo Atendimento"
            />
            <q-btn
              color="negative"
              @click="deleteItem"
              icon="fa fa-trash"
              glossy
              label="Excluir Atendimentos"
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
          <q-tr
            :props="props"
            :class="(props.row.status === 'R')? 'success' : 'warning'"
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
            >
              <q-btn-group flat>
                <q-btn
                  @click="$router.push({name:'clientes-crm.editar', params: {id: props.row.id, cliente_id: $route.params.id }})"
                  icon="fa fa-edit"
                  size="sm"
                  color="primary"
                  glossy
                >
                  <q-tooltip>
                    Editar o Atendimento
                  </q-tooltip>
                </q-btn>
                <q-btn
                  @click="$router.push({name:'clientes-crm.converter-compromisso', params: {id: props.row.id, cliente_id: cliente_id }})"
                  icon="fa fa-exchange-alt"
                  size="sm"
                  color="primary"
                  glossy
                >
                  <q-tooltip>
                    Converter em Compromisso
                  </q-tooltip>
                </q-btn>
              </q-btn-group>
            </q-td>
            <q-td
              key="data"
              :props="props"
            >
              {{ props.row.data | formatDate('DD/MM/YYYY') }}
            </q-td>
            <q-td
              key="funcionario"
              :props="props"
            >
              {{ props.row.usuario.nome }}
            </q-td>
            <q-td
              key="descricao"
              :props="props"
            >
              {{ props.row.descricao }}
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
  name: 'ClientesCrmDatatable',
  props: {

  },
  data: () => ({
    selected: [],
    filter: '',
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
        name: 'data',
        label: 'Data',
        align: 'left',
        sortable: true
      },
      {
        name: 'funcionario',
        label: 'Funcionário',
        align: 'left',
        sortable: true
      },
      {
        name: 'descricao',
        label: 'Descricao',
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
            title: 'Excluir Atendimento',
            message: 'Deseja excluir esses registros?',
            ok: 'Sim, tenho certeza',
            cancel: 'Não'
          })
          .onOk(() => {
            let id = ''
            for (var i = 0; i < this.selected.length; i++) {
              id = this.selected[i]['id']
              this.$store.dispatch('clientesCrm/deleteItem', id)
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
      payload.where = {
        cliente_id: this.$route.params.id
      }
      this.$store.dispatch('clientesCrm/searchList', payload)
        .then((data) => {
          this.pagination = data
        })
    }
  },
  computed: {
    list () {
      return this.$store.state.clientesCrm.list
    },
    loading: {
      get () {
        return this.$store.state.clientesCrm.loading
      },
      set (value) {
        this.$store.commit('clientesCrm/setLoading', value)
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
