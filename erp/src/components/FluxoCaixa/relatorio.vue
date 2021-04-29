<template>
  <div>
    <form @submit.prevent="filtrar">
      <q-card class="q-mb-md bg-primary text-white">
        <q-card-section>
          <div class="text-h6">
            Filtro
          </div>
        </q-card-section>
        <q-separator/>
        <q-card-section class="bg-white text-black">
          <div class="row q-col-gutter-md q-mb-md">
            <div class="col col-sm-9 col-lg-10 col-xs-12 self-center">
              <div class="row q-col-gutter-md">
                <div class="col col-sm-3 col-lg-4 col-xs-12">
                  <label>Data Inicial</label>
                  <div class="row q-col-gutter-md">
                    <div class="col col-sm-6 col-xs-6">
                      <q-select
                          emit-value
                          map-options
                          label="Mês"
                          v-model="data.dataInicialMes"
                          :options="mesesOptions"
                      />
                    </div>
                    <div class="col col-sm-6 col-xs-6">
                      <q-select
                          emit-value
                          map-options
                          label="Ano"
                          v-model="data.dataInicialAno"
                          :options="anosOptions"
                      />
                    </div>
                  </div>
                </div>
                <div class="col col-sm-3 col-lg-4 col-xs-12">
                  <label>Data Final</label>
                  <div class="row q-col-gutter-md">
                    <div class="col col-sm-6 col-xs-6">
                      <q-select
                          emit-value
                          map-options
                          label="Mês"
                          v-model="data.dataFinalMes"
                          :options="mesesOptions"
                      />
                    </div>
                    <div class="col col-sm-6 col-xs-6">
                      <q-select
                          emit-value
                          map-options
                          label="Ano"
                          v-model="data.dataFinalAno"
                          :options="anosOptions"
                      />
                    </div>
                  </div>
                </div>
                <div class="col col-sm-6 col-lg-4 col-xs-12">
                  <label>Empresas</label>
                  <q-checkbox
                      v-model="data.empresa_id"
                      v-for="empresa in empresas"
                      :key="empresa.value"
                      :val="empresa.value"
                      :label="empresa.label"
                      class="full-width"
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
          v-if="content.fluxo"
      >
        <transition
            enter-active-class="animated bounceInLeft"
            leave-active-class="animated bounceOutRight"
            appear
        >
          <div class="row q-col-gutter-md">
            <div class="col col-xs-12">
              <q-card class="bg-primary text-white">
                <q-card-section>
                  <div class="text-h6">
                    Gráfico
                  </div>
                </q-card-section>
                <q-separator/>
                <q-card-section>
                  <div class="bg-white q-pt-md">
                    <ve-histogram
                        :data="chartData"
                        :colors="chartColors"
                    />
                  </div>
                  <table
                      class="q-table table"
                  >
                    <thead>
                    <tr>
                      <th>Mês/ano</th>
                      <th>Recebido</th>
                      <th>Pago</th>
                      <th>Saldo</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="d in chartData.rows"
                        :key="d.id"
                    >
                      <td>{{ d.date }}</td>
                      <td align="right">
                        {{ d.Recebido | currency }}
                      </td>
                      <td align="right">
                        {{ d.Pago | currency }}
                      </td>
                      <td
                          align="right"
                          :class="(d.Saldo > 0)? 'success': 'error'"
                      >
                        {{ d.Saldo | currency }}
                      </td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr v-if="content.fluxoTotais">
                      <th>Total</th>
                      <td align="right">
                        {{ content.fluxoTotais.Recebido | currency }}
                      </td>
                      <td align="right">
                        {{ content.fluxoTotais.Pago | currency }}
                      </td>
                      <td
                          align="right"
                          :class="(content.fluxoTotais.Saldo > 0)? 'success': 'error'"
                      >
                        {{ content.fluxoTotais.Saldo | currency }}
                      </td>
                    </tr>
                    </tfoot>
                  </table>
                </q-card-section>
              </q-card>
            </div>
            <div
                class="col col-xs-12"
                v-if="content.detalhamentoContasReceber"
            >
              <q-card class="bg-blue-curacao text-white">
                <q-card-section>
                  <div class="text-h6">
                    Contas a Receber - Detalhamento por categoria
                  </div>
                </q-card-section>
                <q-separator/>
                <q-card-section>
                  <div class="row q-col-gutter-md">
                    <div class="col col-sm-6 col-xs-12">
                      <div class="bg-white">
                        <ve-pie
                            :data="chartDataContasReceber"
                        />
                      </div>
                    </div>
                    <div class="col col-sm-6 col-xs-12">
                      <table
                          class="q-table table"
                      >
                        <thead>
                        <tr>
                          <th>Categoria de Cliente</th>
                          <th>% do Recebido</th>
                          <th>Recebido</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            v-for="d in ordenar(content.detalhamentoContasReceber)"
                            :key="d.id"
                        >
                          <td>{{ d.categoria }}</td>
                          <td align="right">
                            {{ (d.total * 100 / content.fluxoTotais.Recebido).toFixed(2) }}%
                          </td>
                          <td align="right">
                            {{ d.total | currency }}
                          </td>
                        </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </q-card-section>
              </q-card>
            </div>
            <div
                class="col col-xs-12"
                v-if="content.detalhamentoContasPagar"
            >
              <q-card color="bg-deep-rose text-white">
                <q-card-section>
                  <div class="text-h6">
                    Contas a Pagar - Detalhamento por categoria
                  </div>
                </q-card-section>
                <q-separator/>
                <q-card-section>
                  <div class="row q-col-gutter-md">
                    <div class="col col-sm-6 col-xs-12">
                      <div class="bg-white">
                        <ve-pie
                            :data="chartDataContasPagar"
                        />
                      </div>
                    </div>
                    <div class="col col-sm-6 col-xs-12">
                      <table
                          class="q-table table"
                      >
                        <thead>
                        <tr>
                          <th>Categoria de Conta</th>
                          <th>% do Pago</th>
                          <th>Pago</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            v-for="d in ordenar(content.detalhamentoContasPagar)"
                            :key="d.id"
                        >
                          <td>{{ d.categoria }}</td>
                          <td align="right">
                            {{ (d.total * 100 / content.fluxoTotais.Pago).toFixed(2) }}%
                          </td>
                          <td align="right">
                            {{ d.total | currency }}
                          </td>
                        </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </q-card-section>
              </q-card>
            </div>
          </div>
        </transition>
      </div>
      <div
          class="col col-xs-12"
          v-else
      >
        <AlertEmptyContent/>
      </div>
    </div>
  </div>
</template>

<script>
import {
  date,
  QBtn,
  QBtnGroup,
  QTooltip,
  QSelect,
  QCheckbox,
  QCard,
  QCardSection,
  QSeparator,
  QSpinnerGears
} from 'quasar'
import _ from 'lodash'
import AlertEmptyContent from '../_Layout/alertEmptyContent'

export default {
  name: 'FluxoCaixaRelatorio',
  components: {
    AlertEmptyContent,
    QBtn,
    QBtnGroup,
    QTooltip,
    QSelect,
    QCheckbox,
    QCard,
    QCardSection,
    QSeparator,
    QSpinnerGears
  },
  data: () => ({
    showContent: false,
    data: {
      dataInicialMes: '',
      dataInicialAno: '',
      dataFinalMes: '',
      dataFinalAno: '',
      empresa_id: []
    },
    chartData: {
      columns: ['date', 'Recebido', 'Pago', 'Saldo'],
      rows: []
    },
    chartDataContasPagar: {
      columns: ['categoria', 'total'],
      rows: []
    },
    chartDataContasReceber: {
      columns: ['categoria', 'total'],
      rows: []
    },
    chartColors: ['#3dc1d3', '#c44569', '#16a085']
  }),
  methods: {
    getData () {
      const hoje = new Date()
      const passado = date.subtractFromDate(hoje, {month: 6})
      this.$store.dispatch('empresas/loadList', {})
      // this.$store.dispatch('mesesOptions/loadList', {})
      // this.$store.dispatch('anosOptions/loadList', {})
      // this.$store.dispatch('anosOptions/loadList', {})
      this.data.dataInicialMes = parseInt(date.formatDate(passado, ('M')))
      this.data.dataInicialAno = parseInt(date.formatDate(passado, 'YYYY'))
      this.data.dataFinalMes = parseInt(date.formatDate(hoje, ('M')))
      this.data.dataFinalAno = parseInt(date.formatDate(hoje, ('YYYY')))
    },
    filtrar () {
      this.showContent = false
      this.$store.dispatch('relatorios/relatorio', {relatorio: 'fluxo-caixa', data: this.data})
        .then(() => {
          this.chartData.rows = this.$store.state.relatorios.content.fluxo
          this.chartDataContasPagar.rows = this.$store.state.relatorios.content.detalhamentoContasPagar
          this.chartDataContasReceber.rows = this.$store.state.relatorios.content.detalhamentoContasReceber
          this.showContent = true
        })
    },
    imprimir () {
    },
    exportar () {
      const data = Object.assign({}, this.data)
      this.$store.dispatch('relatorios/csv', {relatorio: 'fluxo-caixacsv', data: data})
        .then(() => {
          const url = `${process.env.DATA_URL}api/download/fluxo-caixa/csv/${this.arqCsv}`
          let link = document.createElement('a')
          link.href = url
          link.click()
        }).catch(error => console.log(error))
    },
    ordenar (list) {
      if (list) {
        return _.orderBy(list, 'total', 'desc')
      }
    }
  },
  computed: {
    mesesOptions () {
      let meses = []
      meses.push({
        label: 'Todos',
        value: ''
      })
      for (let i = 1; i <= 12; i++) {
        meses.push({
          label: i.toString(),
          value: i
        })
      }
      return meses
    },
    anosOptions () {
      let anos = []
      anos.push({
        label: 'Todos',
        value: ''
      })
      for (let i = 2021; i >= 2007; i--) {
        anos.push({
          label: i.toString(),
          value: i
        })
      }
      return anos
    },
    empresas () {
      return _.orderBy(this.$store.state.empresas.list.map(
        data =>
          ({
            label: data.razao_social,
            value: data.id
          })
      ), 'label', 'ASC')
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
