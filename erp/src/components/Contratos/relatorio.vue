<template>
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
        <div class="row q-col-gutter-md">
          <div class="col col-sm-9 col-lg-10 col-xs-12 self-center">
            <div class="row q-col-gutter-md">
              <div class="col col-sm-3 col-xs-12">
                <q-input
                  v-model="model.assinatura_inicial"
                  label="Assinatura Inicial"
                  data-vv-name="assinatura_inicial"
                  v-validate="'required'"
                  :error="errors.has('assinatura_inicial')"
                  :error-message="errors.first('assinatura_inicial')"
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
                          v-model="model.assinatura_inicial"
                          @input="() => $refs.qDateProxy.hide()"
                        />
                      </q-popup-proxy>
                    </q-icon>
                  </template>
                </q-input>
              </div>
              <div class="col col-sm-3 col-xs-12">
                <q-input
                  v-model="model.assinatura_final"
                  label="Assinatura Final"
                  data-vv-name="assinatura_final"
                  v-validate="'required'"
                  :error="errors.has('assinatura_final')"
                  :error-message="errors.first('assinatura_final')"
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
                          v-model="model.assinatura_final"
                          @input="() => $refs.qDateProxy.hide()"
                        />
                      </q-popup-proxy>
                    </q-icon>
                  </template>
                </q-input>
              </div>
              <div class="col col-sm-3 col-xs-12">
                <q-input
                  v-model="model.encerramento_inicial"
                  label="Encerramento Inicial"
                  data-vv-name="encerramento_inicial"
                  v-validate="'required'"
                  :error="errors.has('encerramento_inicial')"
                  :error-message="errors.first('encerramento_inicial')"
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
                          v-model="model.encerramento_inicial"
                          @input="() => $refs.qDateProxy.hide()"
                        />
                      </q-popup-proxy>
                    </q-icon>
                  </template>
                </q-input>
              </div>
              <div class="col col-sm-3 col-xs-12">
                <q-input
                  v-model="model.encerramento_final"
                  label="Encerramento Final"
                  data-vv-name="encerramento_final"
                  v-validate="'required'"
                  :error="errors.has('encerramento_final')"
                  :error-message="errors.first('encerramento_final')"
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
                          v-model="model.encerramento_final"
                          @input="() => $refs.qDateProxy.hide()"
                        />
                      </q-popup-proxy>
                    </q-icon>
                  </template>
                </q-input>
              </div>
              <div class="col col-md-8 col-xs-12">
                <q-select
                  :options="cliente"
                  v-model="model.cliente"
                  label="Cliente"
                  data-vv-name="cliente"
                  :error="errors.has('cliente')"
                  :error-message="errors.first('cliente')"
                />
              </div>
              <div class="col col-md-2 col-xs-12">
                <q-select
                  :options="servico"
                  v-model="model.servico"
                  label="Serviço Contratado"
                  data-vv-name="servico"
                  :error="errors.has('servico')"
                  :error-message="errors.first('servico')"
                />
              </div>
              <div class="col col-md-2 col-xs-12">
                <q-select
                  :options="efluente"
                  v-model="model.efluente"
                  label="Tipo de Efluente"
                  data-vv-name="efluente"
                  :error="errors.has('efluente')"
                  :error-message="errors.first('efluente')"
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
</template>

<script>
import {
  date,
  QInput,
  QDate,
  QPopupProxy,
  QIcon,
  QSelect,
  QBtn,
  QBtnGroup,
  QTooltip,
  QCard,
  QCardSection
} from 'quasar'
import _ from 'lodash'
export default {
  name: 'ContratosRelatorio',
  components: {
    QInput,
    QDate,
    QPopupProxy,
    QIcon,
    QSelect,
    QBtn,
    QBtnGroup,
    QTooltip,
    QCard,
    QCardSection
  },
  data: () => ({
    showContent: false,
    data: {
      assinatura_inicial: '',
      assinatura_final: '',
      encerramento_inicial: '',
      encerramento_final: '',
      cliente: '',
      servico: '',
      efluente: ''
    },
    fepam: [],
    fepam_all: false
  }),
  methods: {
    getData () {
      const hoje = new Date()
      const passado = date.subtractFromDate(hoje, { month: 1 })
      this.data.assinatura_inicial = date.formatDate(hoje, 'DD/MM/YYYY')
      this.data.assinatura_final = date.formatDate(passado, 'DD/MM/YYYY')
      this.data.encerramento_inicial = date.formatDate(hoje, 'DD/MM/YYYY')
      this.data.encerramento_final = date.formatDate(passado, 'DD/MM/YYYY')
      this.$store.dispatch('cliente/loadList', {})
      this.$store.dispatch('servico/loadList', {})
      this.$store.dispatch('efluente/loadList', {})
    },
    filtrar () {
      const data = Object.assign({}, this.data)
      this.showContent = false
      data.assinatura_inicial = date.formatDate(data.assinatura_inicial, 'DD/MM/YYYY')
      data.assinatura_final = date.formatDate(data.assinatura_final, 'DD/MM/YYYY')
      this.$store.dispatch('relatorios/relatorio', { relatorio: 'contratos', data: data })
        .then(() => {
          this.showContent = true
        })
    },
    imprimir () {
      window.print()
    },
    exportar () {
    },
    color (status) {
      return this.$store.state.contratos.colors[status]
    }
  },
  computed: {
    servico () {
      const servico = _.orderBy(this.$store.state.servico.list.map(
        data =>
          ({
            label: data.servico,
            value: data.id
          })
      ), 'label', 'ASC')
      servico.unshift({
        label: 'Todos',
        value: ''
      })
      return servico
    },
    clientes () {
      const clientes = _.orderBy(this.$store.state.clientes.list.map(
        data =>
          ({
            label: data.cliente,
            value: data.id
          })
      ), 'label', 'ASC')
      clientes.unshift({
        label: 'Todos',
        value: ''
      })
      return clientes
    },
    efluente () {
      const efluente = _.orderBy(this.$store.state.efluente.list.map(
        data =>
          ({
            label: data.efluente,
            value: data.id
          })
      ), 'label', 'ASC')
      efluente.unshift({
        label: 'Todos',
        value: ''
      })
      return efluente
    },
    content () {
      return this.$store.state.relatorios.content
    },
    loading () {
      return this.$store.state.relatorios.loading
    }
  },
  mounted () {
    this.getData()
  }
}
</script>
