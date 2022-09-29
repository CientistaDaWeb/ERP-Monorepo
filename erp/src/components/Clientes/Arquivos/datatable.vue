<template>
  <div>
    <q-card class="q-mb-md">
      <q-card-section>
        <div class="text-h6 bg-primary text-white">
          Enviar um novo Arquivo
        </div>
      </q-card-section>
      <q-card-section>
        <div class="row q-col-gutter-md q-pa-md">
          <div class="col col-xs-12 col-md-4 self-center">
            <q-input
              v-model="descricao"
              label="Descrição"
            />
          </div>
          <div class="col col-xs-12 col-md-5 self-center">
            <q-uploader
              ref="uploader"
              :url="url"
              auto-expand
              clearable
              color="primary"
              inverted
              :additional-fields="[{name: 'cliente_id', value:cliente_id}, {name: 'descricao', value:descricao}]"
              :headers="{'Authorization': this.$oauth.getAuthHeader(),'Access-Control-Allow-Origin': '*'}"
              @finish="finish"
            />
          </div>
          <div class="col col-xs-12 col-md-3 self-center">
            <q-btn
              @click="sendFile"
              color="primary"
              class="full-width"
              glossy
              icon="fas fa-file-upload"
              label="Enviar"
            />
          </div>
        </div>
      </q-card-section>
    </q-card>
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
          <q-td
            key="options"
            auto-width
          >
            <q-btn-group flat>
              <q-btn
                color="negative"
                @click="deleteItem(props.row.id)"
                icon="fa fa-trash"
                glossy
              >
                <q-tooltip>
                  {{ module.btn.del }}
                </q-tooltip>
              </q-btn>
              <q-btn
                @click="openURL(props.row.link)"
                icon="fas fa-file-download"
                size="sm"
                color="primary"
                glossy
              >
                <q-tooltip>
                  {{ module.btn.download }}
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
            key="descricao"
            :props="props"
          >
            {{ props.row.descricao }}
          </q-td>
          <q-td
            key="arquivo"
            :props="props"
          >
            {{ props.row.arquivo }}
          </q-td>
        </q-tr>
      </template>
    </q-table>
  </div>
</template>
<script>
import {
  openURL,
  QBtn,
  QBtnGroup,
  QTooltip,
  QTd,
  QTr,
  QTable,
  QInput,
  QIcon,
  QUploader,
  QCard,
  QCardSection
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
    QUploader,
    QCard,
    QCardSection
  },
  name: 'ClientesArquivosDatatable',
  props: {
    clienteId: {
      type: Number,
      required: true
    }
  },
  data: () => ({
    url: `${process.env.DATA_URL}api/clientes-arquivos/upload`,
    selected: [],
    descricao: '',
    pagination: {
      sortBy: 'descricao',
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
        name: 'descricao',
        label: 'Descrição',
        align: 'left',
        sortable: false
      },
      {
        name: 'arquivo',
        label: 'Arquivo',
        align: 'left',
        sortable: false
      }
    ]
  }),
  methods: {
    openURL,
    deleteItem (id) {
      this.$store.dispatch('clientesArquivos/deleteItem', id)
        .then(() => {
          this.searchList({
            pagination: this.pagination,
            filter: this.filter
          })
        })
    },
    searchList (payload) {
      payload.where = {
        cliente_id: this.cliente_id
      }
      this.$store.dispatch('clientesArquivos/searchList', payload)
        .then((data) => {
          this.pagination = data
        })
    },
    finish () {
      this.descricao = ''
      this.$refs.uploader.reset()
      this.$q.notify({
        message: 'Arquivo enviado',
        color: 'positive',
        icon: 'fa fa-smile'
      })
      this.searchList({
        pagination: this.pagination,
        filter: this.filter
      })
    },
    sendFile () {
      this.$refs.uploader.upload()
    }
  },
  computed: {
    list () {
      return this.$store.state.clientesArquivos.list
    },
    loading: {
      get () {
        return this.$store.state.clientesArquivos.loading
      },
      set (value) {
        this.$store.commit('clientesArquivos/setLoading', value)
      }
    },
    filter: {
      get () {
        return this.$store.state.clientesArquivos.filter
      },
      set (value) {
        this.$store.commit('clientesArquivos/setFilter', value)
      }
    },
    module () {
      return this.$store.state.clientesArquivos.module
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
