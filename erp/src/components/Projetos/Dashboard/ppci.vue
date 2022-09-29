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
              @click="$router.push({name:'projetos.editar', params: {id: props.row.id }})"
              icon="fa fa-link"
              size="sm"
              color="primary"
              glossy
            >
              <q-tooltip>
                Editar Projeto
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
          key="ultima_interacao"
          :props="props"
        >
          {{ (props.row.ultima_interacao) ? $options.filters.formatDate(props.row.ultima_interacao.data, 'DD/MM/YYYY') : '-' }}
        </q-td>
        <q-td
          key="projeto"
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
  name: 'ProjetosDashboardPpci',
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
        label: 'Código',
        align: 'center',
        sortable: false
      },
      {
        name: 'ultima_interacao',
        label: 'Última Interação',
        align: 'center',
        sortable: false
      },
      {
        name: 'projeto',
        label: 'Projeto',
        align: 'left',
        sortable: false
      },
      {
        name: 'protocolo',
        label: 'Protocolo',
        align: 'center',
        sortable: false
      }
    ]
  }),
  computed: {
    list () {
      return _.orderBy(this.$store.state.projetos.listPpci, 'ultima_interacao.data', 'ASC')
    },
    loading: {
      get () {
        return this.$store.state.projetos.loading
      },
      set (value) {
        this.$store.commit('projetos/setLoading', value)
      }
    }
  },
  mounted () {
    this.loading = true
    this.$store.dispatch('projetos/loadListPpci').then((data) => {
      this.loading = false
    })
  }
}
</script>

<style>
</style>
