<template>
  <div>
    <form
      @submit.prevent="filtrar"
      class="print-hide"
    >
      <q-card class="q-mb-md bg-primary text-white">
        <q-card-section>
          <div class="text-h6">
            Filtro
          </div>
        </q-card-section>
        <q-separator />
        <q-card-section class="bg-white text-black">
          <div class="row q-col-gutter-md q-mb-md">
            <div class="col col-sm-9 col-lg-10 col-xs-12 self-center">
              <div class="row q-col-gutter-md">
                <div class="col col-sm-4 col-lg-4 col-xs-12">
                  <q-input
                    v-model="data.data_inicial"
                    label="Data Inicial"
                    data-vv-name="Data Inicial"
                    v-validate="'required'"
                    :error="errors.has('Data Inicial')"
                    :error-message="errors.first('Data Inicial')"
                  >
                    <template v-slot:append>
                      <q-icon
                        name="fa fa-calendar"
                        class="cursor-pointer"
                      >
                        <q-popup-proxy
                          transition-show="scale"
                          ref="qDateProxy"
                          transition-hide="scale"
                        >
                          <q-date
                            today-btn
                            mask="DD/MM/YYYY"
                            v-model="data.data_inicial"
                            @input="() => $refs.qDateProxy.hide()"
                          />
                        </q-popup-proxy>
                      </q-icon>
                    </template>
                  </q-input>
                </div>
                <div class="col col-sm-4 col-lg-4 col-xs-12">
                  <q-input
                    v-model="data.data_final"
                    label="Data Final"
                    data-vv-name="Data Final"
                    v-validate="'required'"
                    :error="errors.has('Data Final')"
                    :error-message="errors.first('Data Final')"
                  >
                    <template v-slot:append>
                      <q-icon
                        name="fa fa-calendar"
                        class="cursor-pointer"
                      >
                        <q-popup-proxy
                          transition-show="scale"
                          ref="qDateProxy2"
                          transition-hide="scale"
                        >
                          <q-date
                            today-btn
                            mask="DD/MM/YYYY"
                            v-model="data.data_final"
                            @input="() => $refs.qDateProxy2.hide()"
                          />
                        </q-popup-proxy>
                      </q-icon>
                    </template>
                  </q-input>
                </div>
                <div class="col col-sm-4 col-lg-4 col-xs-12">
                  <q-select
                    filter
                    :options="statusOptions"
                    v-model="data.status"
                    label="Status"
                  />
                </div>
                <div class="col col-sm-6 col-lg-6 col-xs-12">
                  <q-select
                    filter
                    :options="usuarios"
                    v-model="data.usuario_id"
                    label="Funcionário"
                  />
                </div>
                <div class="col col-sm-6 col-lg-6 col-xs-12">
                  <q-select
                    filter
                    :options="clientes"
                    v-model="data.cliente_id"
                    label="Cliente"
                  />
                </div>
              </div>
            </div>
            <div class="col col-sm-3 col-lg-2 col-xs-12 text-right self-center">
              <q-btn-group>
                <q-btn
                  color="info"
                  glossy
                  @click="imprimir"
                  icon="fa fa-print"
                >
                  <q-tooltip>
                    Imprimir
                  </q-tooltip>
                </q-btn>
                <q-btn
                  color="info"
                  glossy
                  @click="exportar"
                  icon="fa fa-file-export"
                >
                  <q-tooltip>
                    Exportar em csv
                  </q-tooltip>
                </q-btn>
                <q-btn
                  type="submit"
                  :loading="loading"
                  color="positive"
                  glossy
                  icon="fa fa-filter"
                >
                  <q-tooltip>
                    Filtrar
                  </q-tooltip>
                </q-btn>
              </q-btn-group>
            </div>
          </div>
        </q-card-section>
      </q-card>
    </form>
    <div
      class="text-center"
      style="padding-top: 200px"
      v-if="loading"
    >
      <q-spinner-gears
        size="50px"
        color="primary"
      />
    </div>
    <div
      class="row q-col-gutter-md"
      v-if="showContent"
    >
      <div
        class="col col-xs-12"
        v-if="content.length"
      >
        <transition
          enter-active-class="animated bounceInLeft"
          leave-active-class="animated bounceOutRight"
          appear
        >
          <table
            ref="table"
            class="q-table table print-show"
          >
            <thead>
              <tr>
                <th>Status</th>
                <th>Código</th>
                <th>Data</th>
                <th>Cliente</th>
                <th>Descrição</th>
                <th>Funcionário</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="d in content"
                :key="d.id"
                :class="(d.status === 'R')? 'success' : 'warning'"
              >
                <td>{{ status[d.status] }}</td>
                <td>{{ d.id }}</td>
                <td>{{ d.data | formatDate('DD/MM/YYYY') }}</td>
                <td>
                  <q-btn
                    icon="fa fa-link"
                    round
                    glossy
                    size="xs"
                    color="primary"
                    class="print-hide float-left q-mr-md"
                    @click="$router.push({name:'clientes.editar', params: {id: d.cliente.id }})"
                  />
                  <span>{{ d.cliente.razao_social }}</span>
                </td>
                <td>{{ d.descricao }}</td>
                <td>{{ d.usuario.nome }}</td>
              </tr>
            </tbody>
          </table>
        </transition>
      </div>
      <div
        class="col col-xs-12"
        v-else
      >
        <AlertEmptyContent />
      </div>
    </div>
  </div>
</template>

<script>
import {
  date,
  QInput,
  QBtn,
  QBtnGroup,
  QTooltip,
  QSelect,
  QDate,
  QPopupProxy,
  QCard,
  QCardSection,
  QSeparator,
  QSpinnerGears
} from 'quasar'
import _ from 'lodash'
import AlertEmptyContent from '../../_Layout/alertEmptyContent'

export default {
  name: 'ClientesCrmRelatorio',
  components: {
    AlertEmptyContent,
    QInput,
    QBtn,
    QBtnGroup,
    QTooltip,
    QSelect,
    QDate,
    QPopupProxy,
    QCard,
    QCardSection,
    QSeparator,
    QSpinnerGears
  },
  data: () => ({
    showContent: false,
    data: {
      data_inicial: '',
      data_final: '',
      status: '',
      empresa_id: '',
      usuario_id: '',
      cliente_id: ''
    }
  }),
  methods: {
    getData () {
      const hoje = new Date()
      const passado = date.subtractFromDate(hoje, { month: 1 })
      this.data.data_inicial = passado
      this.data.data_final = hoje
      this.$store.dispatch('clientes/loadList', {})
      this.$store.dispatch('usuarios/loadList', {})
    },
    filtrar () {
      const data = Object.assign({}, this.data)
      this.showContent = false
      data.data_inicial = date.formatDate(data.data_inicial, 'YYYY-MM-DD')
      data.data_final = date.formatDate(data.data_final, 'YYYY-MM-DD')
      this.$store.dispatch('relatorios/relatorio', { relatorio: 'atendimento', data: data })
        .then(() => {
          this.showContent = true
        })
    },
    imprimir () {
      window.print()
    },
    exportar () {
      const data = Object.assign({}, this.data)
      data.data_inicial = date.formatDate(data.data_inicial, 'YYYY-MM-DD')
      data.data_final = date.formatDate(data.data_final, 'YYYY-MM-DD')
      this.$store.dispatch('relatorios/csv', { relatorio: 'atendimento-csv', data: data })
        .then(() => {
          const url = `${process.env.DATA_URL}api/download/atendimentos/csv/${this.arqCsv}`
          let link = document.createElement('a')
          link.href = url
          link.click()
        })
    }
  },
  computed: {
    clientes () {
      const clientes = _.orderBy(this.$store.state.clientes.list.map(
        data =>
          ({
            label: data.razao_social,
            value: data.id
          })
      ), 'label', 'ASC')
      clientes.unshift({
        label: 'Todos',
        value: ''
      })
      return clientes
    },
    usuarios () {
      const usuarios = _.orderBy(this.$store.state.usuarios.list.map(
        data =>
          ({
            label: data.nome,
            value: data.id
          })
      ), 'label', 'ASC')
      usuarios.unshift({
        label: 'Todos',
        value: ''
      })
      return usuarios
    },
    status () {
      return this.$store.state.clientesCrm.status
    },
    statusOptions () {
      const status = this.$store.state.clientesCrm.statusOptions
      status.unshift({
        label: 'Todos',
        value: ''
      })
      return status
    },
    content () {
      return this.$store.state.relatorios.content
    },
    loading () {
      return this.$store.state.relatorios.loading
    },
    arqCsv () {
      return this.$store.state.relatorios.arqCsv
    }
  },
  mounted () {
    this.getData()
  }
}
</script>

<style>
</style>
