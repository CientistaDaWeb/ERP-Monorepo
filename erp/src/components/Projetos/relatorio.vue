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
              <div class="col col-sm-3 col-xs-12">
                <q-input
                  v-model="model.data_inicial"
                  label="Data Inicial"
                  data-vv-name="data_inicial"
                  v-validate="'required'"
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
              <div class="col col-sm-3 col-xs-12">
                <q-input
                  v-model="model.data_final"
                  label="Data Final"
                  data-vv-name="data_final"
                  v-validate="'required'"
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
              <div class="col col-sm-6 col-xs-12">
                <q-select
                  :options="usuario"
                  v-model="model.usuario"
                  label="Usuário"
                  data-vv-name="usuario"
                  :error="errors.has('usuario')"
                  :error-message="errors.first('usuario')"
                />
              </div>
              <div class="col col-sm-8 col-xs-12">
                <q-select
                  :options="projeto"
                  v-model="model.projeto"
                  label="Projeto"
                  data-vv-name="projeto"
                  :error="errors.has('projeto')"
                  :error-message="errors.first('projeto')"
                />
              </div>
              <div class="col col-md-4 col-xs-12">
                <q-select
                  :options="categoria"
                  v-model="model.categoria"
                  label="Categoria"
                  data-vv-name="categoria"
                  :error="errors.has('categoria')"
                  :error-message="errors.first('categoria')"
                />
              </div>
              <div class="col col-md-8 col-xs-12">
                <q-select
                  :options="construtora"
                  v-model="model.construtora"
                  label="Construtora"
                  data-vv-name="construtora"
                  :error="errors.has('construtora')"
                  :error-message="errors.first('construtora')"
                />
              </div>
              <div class="col col-md-4 col-xs-12">
                <q-select
                  :options="arquiteto"
                  v-model="model.arquiteto"
                  label="Arquiteto"
                  data-vv-name="arquiteto"
                  :error="errors.has('arquiteto')"
                  :error-message="errors.first('arquiteto')"
                />
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
      data_inicial: '',
      data_final: '',
      usuario: '',
      projeto: '',
      categoria: '',
      construtora: '',
      arquiteto: ''
    }
  }),
  methods: {
    getData () {
      const hoje = new Date()
      const passado = date.subtractFromDate(hoje, { month: 1 })
      this.data.data_inicial = passado
      this.data.data_final = hoje
      this.$store.dispatch('usuario/loadList', {})
      this.$store.dispatch('projeto/loadList', {})
      this.$store.dispatch('categoria/loadList', {})
      this.$store.dispatch('construtora/loadList', {})
      this.$store.dispatch('arquiteto/loadList', {})
    },
    filtrar () {
      const data = Object.assign({}, this.data)
      this.showContent = false
      data.data_inicial = date.formatDate(data.data_inicial, 'YYYY-MM-DD')
      data.data_final = date.formatDate(data.data_final, 'YYYY-MM-DD')
      this.$store.dispatch('relatorios/relatorio', { relatorio: 'projetos', data: data })
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
    usuario () {
      return _.orderBy(this.$store.state.usuario.list.map(
        data =>
          ({
            label: data.usuario,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    projeto () {
      return _.orderBy(this.$store.state.projeto.list.map(
        data =>
          ({
            label: data.projeto,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    categoria () {
      return _.orderBy(this.$store.state.categoria.list.map(
        data =>
          ({
            label: data.categoria,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    construtora () {
      return _.orderBy(this.$store.state.construtora.list.map(
        data =>
          ({
            label: data.construtora,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    arquiteto () {
      return _.orderBy(this.$store.state.arquiteto.list.map(
        data =>
          ({
            label: data.arquiteto,
            value: data.id
          })
      ), 'label', 'ASC')
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
