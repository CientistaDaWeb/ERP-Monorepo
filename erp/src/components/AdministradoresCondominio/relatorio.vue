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
                <div class="col col-sm-12 col-xs-12">
                  <q-select
                    filter
                    :options="administradores"
                    v-model="data.administrador_id"
                    label="Administrador de Condomínio"
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
                <th>#</th>
                <th>Cliente</th>
                <th>Telefones</th>
                <th>Endereço</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(d, i) in content"
                :key="d.id"
              >
                <td align="center">
                  {{ ++i }}
                </td>
                <td>
                  <q-btn
                    icon="fa fa-link"
                    round
                    glossy
                    size="xs"
                    color="primary"
                    class="print-hide float-left q-mr-md"
                    type="a"
                    target="_blank"
                    @click="$router.push({name:'clientes.editar', params: {id: d.id }})"
                  />
                  <span>{{ d.razao_social }}</span>
                </td>
                <td><p v-html="$options.filters.formatPhones(d.telefones)" /></td>
                <td>
                  <p v-if="d.enderecos[0]">
                    {{ d.enderecos[0].endereco }}, {{ d.enderecos[0].numero }} {{
                      d.enderecos[0].complemento }} - {{ d.enderecos[0].bairro }} - {{ d.enderecos[0].estado.uf }}
                  </p>
                </td>
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
  QBtn,
  QBtnGroup,
  QTooltip,
  QSelect,
  QCard,
  QCardSection,
  QSeparator,
  QSpinnerGears
} from 'quasar'
import _ from 'lodash'
import AlertEmptyContent from '../_Layout/alertEmptyContent'

export default {
  name: 'AdministradoresCondominioRelatorio',
  components: {
    AlertEmptyContent,
    QBtn,
    QBtnGroup,
    QTooltip,
    QSelect,
    QCard,
    QCardSection,
    QSeparator,
    QSpinnerGears
  },
  data: () => ({
    showContent: false,
    data: {
      administrador_id: ''
    }
  }),
  methods: {
    getData () {
      this.$store.dispatch('administradoresCondominio/loadList', {})
    },
    filtrar () {
      const data = Object.assign({}, this.data)
      this.showContent = false
      this.$store.dispatch('relatorios/relatorio', { relatorio: 'clientes-condominio', data: data })
        .then(() => {
          this.showContent = true
        })
    },
    exportar () {
      const data = Object.assign({}, this.data)
      this.$store.dispatch('relatorios/csv', { relatorio: 'clientes-condominio-csv', data: data })
        .then(() => {
          const url = `${process.env.DATA_URL}api/download/clientes-condominio/csv/${this.arqCsv}`
          let link = document.createElement('a')
          link.href = url
          link.click()
        })
    },
    imprimir () {
      window.print()
    }
  },
  computed: {
    administradores () {
      const options = _.orderBy(this.$store.state.administradoresCondominio.list.map(
        data =>
          ({
            label: data.nome,
            value: data.id
          })
      ), 'label', 'ASC')
      options.unshift({
        label: 'Sem Administradores',
        value: ''
      })

      return options
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
