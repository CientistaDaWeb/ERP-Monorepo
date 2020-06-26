<template>
  <q-table
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
              @click="$router.push({name:'clientes.editar', params: {id: props.row.id }})"
              icon="fa fa-link"
              size="sm"
              color="primary"
              glossy
            >
              <q-tooltip>
                Editar Atendimento
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
          key="data"
          :props="props"
        >
          {{ props.row.data | formatDate('DD/MM/YYYY') }}
        </q-td>
        <q-td
          key="cliente"
          :props="props"
        >
          {{ props.row.cliente.razao_social }}
        </q-td>
        <q-td
          key="descricao"
          :props="props"
        >
          {{ props.row.descricao }}
        </q-td>
        <q-td
          key="funcionario"
          :props="props"
        >
          {{ props.row.usuario.nome }}
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
  name: 'ClientesDashboardAtendimentos',
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
        name: 'data',
        label: 'Data',
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
        name: 'descricao',
        label: 'Descrição',
        align: 'left',
        sortable: false
      },
      {
        name: 'funcionario',
        label: 'Funcionário',
        align: 'left',
        sortable: false
      }
    ]
  }),
  computed: {
    list () {
      return _.orderBy(this.$store.state.clientesCrm.listAbertos, 'data', 'ASC')
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
    this.loading = true
    this.$store.dispatch('clientesCrm/loadListAbertos').then((data) => {
      this.loading = false
    })
  }
}
</script>

<style>
</style>
