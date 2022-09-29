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
              @click="$router.push({name:'contas-receber.baixar', params: {id: props.row.id }})"
              icon="fa fa-link"
              size="sm"
              color="primary"
              glossy
            >
              <q-tooltip>
                Dar Baixa
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
          key="data_vencimento"
          :props="props"
        >
          {{ props.row.data_vencimento | formatDate('DD/MM/YYYY') }}
        </q-td>
        <q-td
          key="cliente"
          :props="props"
        >
          {{ props.row.orcamento.cliente.razao_social }}
        </q-td>
        <q-td
          key="valor"
          :props="props"
        >
          {{ props.row.valor | currency }}
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
  name: 'ContasReceberDashboardAtrasadas',
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
        name: 'data_vencimento',
        label: 'Vencimento',
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
        name: 'valor',
        label: 'Valor',
        align: 'right',
        sortable: false,
        style: 'width: 120px'
      }
    ]
  }),
  computed: {
    list () {
      return _.orderBy(this.$store.state.contasReceber.listAtrasadas, 'data_vencimento', 'ASC')
    },
    loading: {
      get () {
        return this.$store.state.contasReceber.loading
      },
      set (value) {
        this.$store.commit('contasReceber/setLoading', value)
      }
    }
  },
  mounted () {
    this.loading = true
    this.$store.dispatch('contasReceber/loadListAtrasadas').then((data) => {
      this.loading = false
    })
  }
}
</script>

<style>
</style>
