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
            color="red"
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
        <q-tr
          :props="props"
          :class="(props.row.certificados)? 'success' : 'error'"
        >
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
                @click="$router.push({name:'mtrs.editar', params: {id: props.row.id }})"
                icon="fa fa-edit"
                size="sm"
                text-color="blue-9"
              >
                <q-tooltip
                  content-class="bg-indigo"
                  content-style="font-size: 12px"
                >
                  Editar Mtr
                </q-tooltip>
              </q-btn>
            </q-btn-group>
          </q-td>
          <q-td
            key="codigo"
            :props="props"
          >
            {{ props.row.ordem_servico.codigo }}
          </q-td>
          <q-td
            key="certificado"
            :props="props"
          >
            {{ props.row.mtr }}
          </q-td>
          <q-td
            key="ordem_servico"
            :props="props"
          >
            {{ props.row.ordem_servico.codigo }}
          </q-td>
          <q-td
            key="cliente"
            :props="props"
          >
            {{ props.row.ordem_servico.orcamento.cliente.razao_social }}
          </q-td>
          <q-td
            key="dono"
            :props="props"
          >
            {{ props.row.donoHumanized }}
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
  name: 'MtrsDatatable',
  data: () => ({
    selected: [],
    pagination: {
      sortBy: 'mtr',
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
        name: 'certificado',
        label: 'Certificado',
        align: 'center',
        sortable: false
      },
      {
        name: 'codigo',
        label: 'MTR',
        align: 'center',
        sortable: false,
        style: 'width: 90px'
      },
      {
        name: 'ordem_servico',
        label: 'Ordem de Serviço',
        align: 'left',
        sortable: false
      },
      {
        name: 'cliente',
        label: 'Cliente',
        align: 'left',
        sortable: false
      },
      {
        name: 'dono',
        label: 'Dono',
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
          .onOk(() => {
            let id = ''
            for (var i = 0; i < this.selected.length; i++) {
              id = this.selected[i]['id']
              this.$store.dispatch('mtrs/deleteItem', id)
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
      this.$store.dispatch('mtrs/searchList', payload)
        .then((data) => {
          this.pagination = data
        })
    }
  },
  computed: {
    list () {
      return this.$store.state.mtrs.list
    },
    module () {
      return this.$store.state.mtrs.module
    },
    loading: {
      get () {
        return this.$store.state.mtrs.loading
      },
      set (value) {
        this.$store.commit('mtrs/setLoading', value)
      }
    },
    filter: {
      get () {
        return this.$store.state.mtrs.filter
      },
      set (value) {
        this.$store.commit('mtrs/setFilter', value)
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
