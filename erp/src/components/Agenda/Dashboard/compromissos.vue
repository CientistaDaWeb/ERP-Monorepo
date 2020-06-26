<template>
  <q-table
    :loading="loading"
    :data="list"
    :columns="columns"
    dense
    color="primary"
    class="bg-grey-3 table table-warning"
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
              @click="$router.push({name:'agenda.editar', params: {id: props.row.id }})"
              icon="fa fa-link"
              size="sm"
              color="primary"
              glossy
            >
              <q-tooltip>
                Editar Compromisso
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
          key="usuario"
          :props="props"
        >
          {{ props.row.usuario.nome }}
        </q-td>
        <q-td
          key="data"
          :props="props"
        >
          {{ props.row.data | formatDate('DD/MM/YYYY') }} {{ props.row.hora }}
        </q-td>
        <q-td
          key="titulo"
          :props="props"
        >
          {{ props.row.titulo }}
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

export default {
  name: 'AgendaDashboardCompromissos',
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
        name: 'usuario',
        label: 'Usuário',
        align: 'left',
        sortable: false
      },
      {
        name: 'data',
        label: 'Data',
        align: 'center',
        sortable: false
      },
      {
        name: 'titulo',
        label: 'Título',
        align: 'center',
        sortable: false
      },
      {
        name: 'cliente',
        label: 'Cliente',
        align: 'center',
        sortable: false
      },
      {
        name: 'descricao',
        label: 'Descrição',
        align: 'left',
        sortable: false
      }
    ]
  }),
  computed: {
    list () {
      return this.$store.state.usuariosCompromissos.listCompromissos
    },
    loading: {
      get () {
        return this.$store.state.usuariosCompromissos.loading
      },
      set (value) {
        this.$store.commit('usuariosCompromissos/setLoading', value)
      }
    }
  },
  mounted () {
    this.loading = true
    this.$store.dispatch('usuariosCompromissos/loadListCompromissos').then((data) => {
      this.loading = false
    })
  }
}
</script>

<style>
</style>
