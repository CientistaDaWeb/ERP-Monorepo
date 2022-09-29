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
            @click="$router.push({name:'projetos.novo'})"
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
                @click="$router.push({name:'projetos.editar', params: {id: props.row.id }})"
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
            key="nome"
            :props="props"
          >
            {{ props.row.nome }}
          </q-td>
          <q-td
            key="protocolo"
            :props="props"
          >
            {{ props.row.numero_protocolo }}
          </q-td>
          <q-td
            key="proprietario"
            :props="props"
          >
            {{ props.row.proprietario }}
          </q-td>
          <q-td
            key="arquiteto"
            :props="props"
          >
            {{ (props.row.arquiteto)? props.row.arquiteto.nome : 'Não informado' }}
          </q-td>
          <q-td
            key="construtora"
            :props="props"
          >
            {{ (props.row.construtora) ? props.row.construtora.nome : 'Não informado' }}
          </q-td>
          <q-td
            key="categoria"
            :props="props"
          >
            {{ props.row.categoria.categoria }}
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
  name: 'ProjetosDatatable',
  data: () => ({
    selected: [],
    pagination: {
      sortBy: 'nome',
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
        name: 'nome',
        label: 'Nome',
        align: 'left',
        sortable: false
      },
      {
        name: 'protocolo',
        label: 'Protocolo',
        align: 'left',
        sortable: false
      },
      {
        name: 'proprietario',
        label: 'Proprietário',
        align: 'left',
        sortable: false
      },
      {
        name: 'arquiteto',
        label: 'Arquiteto',
        align: 'left',
        sortable: false
      },
      {
        name: 'construtora',
        label: 'Construtora',
        align: 'left',
        sortable: false
      },
      {
        name: 'categoria',
        label: 'Categoria',
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
              this.$store.dispatch('projetos/deleteItem', id)
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
      this.$store.dispatch('projetos/searchList', payload)
        .then((data) => {
          this.pagination = data
        })
    }
  },
  computed: {
    list () {
      return this.$store.state.projetos.list
    },
    loading: {
      get () {
        return this.$store.state.projetos.loading
      },
      set (value) {
        this.$store.commit('projetos/setLoading', value)
      }
    },
    filter: {
      get () {
        return this.$store.state.projetos.filter
      },
      set (value) {
        this.$store.commit('projetos/setFilter', value)
      }
    },
    module () {
      return this.$store.state.projetos.module
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
