<template>
  <q-table
    title="Atrasadas"
    :loading="loading"
    :data="list"
    :columns="columns"
    dense
    color="primary"
    class="bg-grey-3 table table-error"
  >
    <template
      slot="body"
      slot-scope="props"
    >
      <q-tr :props="props">
        <q-td
          key="options"
          auto-width
        >
          <q-btn-group flat>
            <q-btn
              @click="$router.push({name:'ordens-servico.editar', params: {id: props.row.id }})"
              icon="fa fa-link"
              size="sm"
              color="primary"
              glossy
            >
              <q-tooltip>
                Editar Ordem de Serviço
              </q-tooltip>
            </q-btn>
          </q-btn-group>
        </q-td>
        <q-td
          key="id"
          :props="props"
        >
          {{ props.row.id }}
        </q-td>
        <q-td
          key="data_coleta"
          :props="props"
        >
          {{ props.row.data_coleta | formatDate('DD/MM/YYYY') }}
        </q-td>
        <q-td
          key="cliente"
          :props="props"
        >
          {{ props.row.orcamento.cliente.razao_social }}
        </q-td>
      </q-tr>
    </template>
  </q-table>
</template>

<script>
import {
  QTable,
  QTr,
  QTd,
  QBtn,
  QBtnGroup,
  QTooltip
} from 'quasar'
import _ from 'lodash'

export default {
  name: 'OrdensServicoDashboardAtrasadas',
  components: {
    QTable,
    QTr,
    QTd,
    QBtn,
    QBtnGroup,
    QTooltip
  },
  data: () => ({
    columns: [
      {
        name: 'options'
      },
      {
        name: 'id',
        label: 'Cógigo',
        align: 'center',
        sortable: false
      },
      {
        name: 'data_coleta',
        label: 'Data de Coleta',
        align: 'center',
        sortable: false
      },
      {
        name: 'cliente',
        label: 'Cliente',
        align: 'left',
        sortable: false
      }
    ]
  }),
  computed: {
    list () {
      return _.orderBy(this.$store.state.ordensServico.listAtrasadas, 'data_coleta', 'ASC')
    },
    loading: {
      get () {
        return this.$store.state.ordensServico.loading
      },
      set (value) {
        this.$store.commit('ordensServico/setLoading', value)
      }
    }
  },
  mounted () {
    this.loading = true
    this.$store.dispatch('ordensServico/loadListAtrasadas').then((data) => {
      this.loading = false
    })
  }
}
</script>

<style>
</style>
