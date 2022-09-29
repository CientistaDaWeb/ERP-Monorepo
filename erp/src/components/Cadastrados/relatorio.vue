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
          <div class="col col-xs-12">
            <div class="row q-col-gutter-md">
              <div class="col col-sm-2 col-xs-12">
                <q-input
                  v-model="model.data_inicial"
                  label="Data Inicial"
                  data-vv-name="data_inicial"
                  :error="errors.has('data_inicial')"
                  :error-message="errors.first('data_inicial')"
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
                          v-model="model.data_inicial"
                          @input="() => $refs.qDateProxy.hide()"
                        />
                      </q-popup-proxy>
                    </q-icon>
                  </template>
                </q-input>
              </div>
              <div class="col col-sm-2 col-xs-12">
                <q-input
                  v-model="model.data_final"
                  label="Data Final"
                  data-vv-name="data_final"
                  :error="errors.has('data_final')"
                  :error-message="errors.first('data_final')"
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
                          v-model="model.data_final"
                          @input="() => $refs.qDateProxy.hide()"
                        />
                      </q-popup-proxy>
                    </q-icon>
                  </template>
                </q-input>
              </div>
            </div>
            <div class="col col-md-6 col-xs-12">
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
  QBtn,
  QBtnGroup,
  QTooltip,
  QCard,
  QCardSection
} from 'quasar'
export default {
  name: 'CadastradosRelatorio',
  components: {
    QInput,
    QDate,
    QPopupProxy,
    QIcon,
    QBtn,
    QBtnGroup,
    QTooltip,
    QCard,
    QCardSection
  },
  data: () => ({
    showContent: false,
    data: {
      data_inicial: '',
      data_final: '',
      status: '',
      funcionario: ''
    }
  }),
  methods: {
    getData () {
      const hoje = new Date()
      const passado = date.subtractFromDate(hoje, { month: 1 })
      this.data.data_inicial = passado
      this.data.data_final = hoje
    },
    filtrar () {
      const data = Object.assign({}, this.data)
      this.showContent = false
      data.data_inicial = date.formatDate(data.data_inicial, 'YYYY-MM-DD')
      data.data_final = date.formatDate(data.data_final, 'YYYY-MM-DD')
      this.$store.dispatch('relatorios/relatorio', { relatorio: 'cadastrados', data: data })
        .then(() => {
          this.showContent = true
        })
    },
    imprimir () {
      window.print()
    },
    exportar () {
    }
  },
  computed: {
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
