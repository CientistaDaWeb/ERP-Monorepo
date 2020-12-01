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
        slot="top-left"
      >
        <q-btn-group outline>
          <q-btn
            color="positive"
            @click="$router.push({name:'orcamentos.novo', params: {cliente_id: $route.params.id}})"
            icon="fa fa-plus-circle"
            glossy
            label="Novo Orçamento"
          />
          <q-btn
            color="negative"
            @click="deleteItem"
            icon="fa fa-trash"
            glossy
            label="Excluir Orçamento"
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
          :class="statusColor(props.row.status)"
        >
          <q-td
            key="options"
            auto-width
          >
            <q-btn-group flat>
              <q-btn
                @click="$router.push({name:'orcamentos.editar', params: {id: props.row.id }})"
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
            key="empresa"
            :props="props"
          >
            {{ props.row.empresa.razao_social }}
          </q-td>
          <q-td
            key="data_emissao"
            :props="props"
          >
            {{ props.row.data_emissao | formatDate('DD/MM/YYYY') }}
          </q-td>
          <q-td
            key="status"
            :props="props"
          >
            {{ props.row.statusHumanized }}
          </q-td>
          <q-td
            key="os_count"
            :props="props"
          >
            {{ props.row.osCount }}
          </q-td>
          <q-td
            key="faturas_count"
            :props="props"
          >
            {{ props.row.faturasCount }}
          </q-td>
          <q-td
            key="saldo"
            :props="props"
          >
            {{ props.row.saldo | currency }}
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

  },
  name: 'ClientesOrcamentosDatatable',
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
        name: 'empresa',
        label: 'Empresa',
        align: 'left',
        sortable: false
      },
      {
        name: 'data_emissao',
        label: 'Data de Emissão',
        align: 'center',
        sortable: false
      },
      {
        name: 'status',
        label: 'Status',
        align: 'left',
        sortable: false
      },
      {
        name: 'os_count',
        label: 'Nº OS',
        align: 'center',
        sortable: false
      },
      {
        name: 'faturas_count',
        label: 'Nª Fat',
        align: 'center',
        sortable: false
      },
      {
        name: 'saldo',
        label: 'Saldo',
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
              this.$store.dispatch('orcamentos/deleteItem', id)
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
      // console.log(payload)
      payload.where = {
        cliente_id: this.$route.params.id
      }
      this.$store.dispatch('orcamentos/searchList', payload)
        .then((data) => {
          this.pagination = data
        })
    },
    statusColor (status) {
      const colors = this.$store.state.orcamentos.colors
      return colors[status]
    }
  },
  computed: {
    list () {
      return this.$store.state.orcamentos.list
    },
    loading: {
      get () {
        return this.$store.state.orcamentos.loading
      },
      set (value) {
        this.$store.commit('orcamentos/setLoading', value)
      }
    },
    filter: {
      get () {
        return this.$store.state.orcamentos.filter
      },
      set (value) {
        this.$store.commit('orcamentos/setFilter', value)
      }
    },
    module () {
      return this.$store.state.orcamentos.module
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
