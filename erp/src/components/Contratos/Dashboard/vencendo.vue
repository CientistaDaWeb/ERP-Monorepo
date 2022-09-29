<template>
  <q-table
    :data="tableData"
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
              @click="$router.push({name:'contratos.editar', params: {id: props.row.id }})"
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
          key="cliente"
          :props="props"
        >
          {{ props.row.cliente }}
        </q-td>
        <q-td
          key="data"
          :props="props"
        >
          {{ props.row.data }}
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
  name: 'ContratosDashboardVencendo',
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
        name: 'data',
        label: 'Data',
        align: 'left',
        sortable: false
      }
    ],
    tableData: [
      {
        id: 1,
        data: '01/01/2019',
        cliente: 'Cliente'
      },
      {
        id: 1,
        data: '01/01/2019',
        cliente: 'Cliente'
      },
      {
        id: 1,
        data: '01/01/2019',
        cliente: 'Cliente'
      },
      {
        id: 1,
        data: '01/01/2019',
        cliente: 'Cliente'
      },
      {
        id: 1,
        data: '01/01/2019',
        cliente: 'Cliente'
      },
      {
        id: 1,
        data: '01/01/2019',
        cliente: 'Cliente'
      },
      {
        id: 1,
        data: '01/01/2019',
        cliente: 'Cliente'
      },
      {
        id: 1,
        data: '01/01/2019',
        cliente: 'Cliente'
      },
      {
        id: 1,
        data: '01/01/2019',
        cliente: 'Cliente'
      }
    ]
  })
}
</script>

<style>
</style>
