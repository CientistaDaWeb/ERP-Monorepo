<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-6 col-xs-12">
            <q-select
              :options="clientesEnderecos"
              v-model="selectClientesEnderecos"
              label="Endereço"
              data-vv-name="endereco"
              v-validate="'required'"
              :error="errors.has('endereco')"
              :error-message="errors.first('endereco')"
            />
          </div>
          <div class="col col-sm-6 col-xs-12">
            <q-select
              :options="empresa"
              v-model="selectEmpresa"
              label="Empresa"
              data-vv-name="empresa"
              v-validate="'required'"
              :error="errors.has('empresa')"
              :error-message="errors.first('empresa')"
            />
          </div>
          <div class="col col-sm-6 col-xs-12">
            <q-select
              :options="transportadores"
              v-model="selectTransportadores"
              label="Transportador"
              data-vv-name="transportador"
              v-validate="'required'"
              :error="errors.has('transportador')"
              :error-message="errors.first('transportador')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              v-model="data_coleta"
              label="Data de Coleta"
              data-vv-name="data_coleta"
              v-validate="'required'"
              :error="errors.has('data_coleta')"
              :error-message="errors.first('data_coleta')"
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
                      v-model="data_coleta"
                      @input="() => $refs.qDateProxy.hide()"
                    />
                  </q-popup-proxy>
                </q-icon>
              </template>
            </q-input>
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              type="time"
              v-model="model.hora_coleta"
              label="Hora Coleta"
              data-vv-name="hora_coleta"
              v-validate="'required'"
              :error="errors.has('hora_coleta')"
              :error-message="errors.first('hora_coleta')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              mask="#.##"
              fill-mask="0"
              reverse-fill-mask
              prefix="R$"
              v-model="model.valor"
              label="Valor"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              mask="#.##"
              fill-mask="0"
              reverse-fill-mask
              prefix="R$"
              v-model="model.desconto"
              label="Desconto"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-select
              :options="coletas"
              v-model="selectColetas"
              label="Nº Coletas Programadas"
              data-vv-name="numero_coletas"
              v-validate="'required'"
              :error="errors.has('numero_coletas')"
              :error-message="errors.first('numero_coletas')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-select
              :options="statusOptions"
              v-model="selectStatusOptions"
              label="Status"
              data-vv-name="status"
              v-validate="'required'"
              :error="errors.has('status')"
              :error-message="errors.first('status')"
            />
          </div>
          <div class="col col-sm-12 col-xs-12">
            <q-input
              type="textarea"
              rows="3"
              v-model="model.observacoes"
              label="Observações"
              data-vv-name="observacoes"
              v-validate="'required'"
              :error="errors.has('observacoes')"
              :error-message="errors.first('observacoes')"
            />
          </div>
        </div>
        <div class="row q-col-gutter-md">
          <div class="col col-sm-3 col-xs-12">
            <q-input
              v-model="model.ordem_compra"
              label="Ordem de Compra"
              data-vv-name="ordem_compra"
              v-validate="'required'"
              :error="errors.has('ordem_compra')"
              :error-message="errors.first('ordem_compra')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-select
              :options="tipoReservatorios"
              v-model="selectTipoReservatorios"
              label="Tipo de Reservatório"
              data-vv-name="tipo_reservatorio"
              v-validate="'required'"
              :error="errors.has('tipo_reservatorio')"
              :error-message="errors.first('tipo_reservatorio')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-select
              :options="coletas"
              v-model="selectColetas"
              label="Acesso Ponto de Coleta"
              data-vv-name="ponto_coleta"
              v-validate="'required'"
              :error="errors.has('ponto_coleta')"
              :error-message="errors.first('ponto_coleta')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              v-model="model.metragem_mangueira"
              label="Metragem de Mangueira Necessária"
              data-vv-name="metragem_mangueira"
              v-validate="'required'"
              :error="errors.has('metragem_mangueira')"
              :error-message="errors.first('metragem_mangueira')"
            />
          </div>
          <div class="col col-sm-9 col-xs-12">
            <q-input
              v-model="model.situacao_tampas"
              label="Situação das Tampas"
              data-vv-name="situacao_tampas"
              v-validate="'required'"
              :error="errors.has('situacao_tampas')"
              :error-message="errors.first('situacao_tampas')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-select
              :options="situacaoEfluentes"
              v-model="selectSituacaoEfluentes"
              label="Situação dos Efluentes"
              data-vv-name="situacao_efluentes"
              v-validate="'required'"
              :error="errors.has('situacao_efluentes')"
              :error-message="errors.first('situacao_efluentes')"
            />
          </div>
          <div class="col col-sm-12 col-xs-12">
            <q-input
              type="textarea"
              rows="3"
              v-model="model.observacoes_poscoleta"
              label="Observações Pós Coleta"
              data-vv-name="obs_pos_coleta"
              v-validate="'required'"
              :error="errors.has('obs_pos_coleta')"
              :error-message="errors.first('obs_pos_coleta')"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-input
              v-model="model.horas_trabalhadas"
              label="Horas Trabalhadas"
              data-vv-name="horas_trabalhadas"
              v-validate="'required'"
              :error="errors.has('horas_trabalhadas')"
              :error-message="errors.first('horas_trabalhadas')"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-select
              :options="checagemFinal"
              v-model="selectChecagemFinal"
              label="Checagem Final"
              data-vv-name="checagem_final"
              v-validate="'required'"
              :error="errors.has('checagem_final')"
              :error-message="errors.first('checagem_final')"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-select
              :options="faturada"
              v-model="selectFaturada"
              label="Faturada"
              data-vv-name="faturada"
              v-validate="'required'"
              :error="errors.has('faturada')"
              :error-message="errors.first('faturada')"
            />
          </div>
          <div class="col col-sm-12 col-xs-12">
            <q-input
              type="textarea"
              rows="3"
              v-model="model.observacao_faturamento"
              label="Observações para Faturamento"
              data-vv-name="observacao_faturamento"
              v-validate="'required'"
              :error="errors.has('observacao_faturamento')"
              :error-message="errors.first('observacao_faturamento')"
            />
          </div>
        </div>
      </div>
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-xs-6">
            <q-btn
              color="negative"
              glossy
              @click="$router.push({name:'ordens-servico.index'})"
              label="Cancelar"
              icon="fa fa-times-circle"
            />
          </div>
          <div class="col col-xs-6 text-right">
            <q-btn
              type="submit"
              :loading="submitting"
              color="positive"
              glossy
              label="Salvar"
              icon="fa fa-save"
            />
          </div>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
import {
  QBtn,
  QSelect,
  QInput,
  QDate,
  QPopupProxy
} from 'quasar'
// import _ from 'lodash'
import moment from 'moment'
// import datatableVue from '../Certificados/datatable.vue'
export default {
  name: 'OrdensServicoForm',
  props: {
    action: {
      type: String,
      default: 'new'
    },
    id: {
      type: Number,
      default: null
    }
  },
  components: {
    QBtn,
    QSelect,
    QInput,
    QDate,
    QPopupProxy
  },
  data: () => ({
    data_coleta: '',
    submitting: false,
    clientesEnderecos: [],
    selectClientesEnderecos: {
      label: '',
      value: ''
    },
    statusOptions: [],
    selectStatusOptions: {
      label: '',
      value: ''
    },
    transportadores: [],
    selectTransportadores: {
      label: '',
      value: ''
    },
    coletas: [],
    selectColetas: {
      label: '',
      value: ''
    },
    tipoReservatorios: [],
    selectTipoReservatorios: {
      label: '',
      value: ''
    },
    situacaoEfluentes: [],
    selectSituacaoEfluentes: {
      label: '',
      value: ''
    },
    checagemFinal: [],
    selectChecagemFinal: {
      label: '',
      value: ''
    },
    faturada: [],
    selectFaturada: {
      label: '',
      value: ''
    },

    empresa: [],
    selectEmpresa: {
      label: '',
      value: ''
    }
  }),
  methods: {
    getData () {
      if (this.id) {
        this.$store.dispatch('empresas/loadList', {})
        this.$store.dispatch('transportadores/loadList', {})
        this.$store.dispatch('clientesEnderecos/loadList', {})
        this.$store.dispatch('ordensServico/loadItem', this.id)
      } else {
        // console.log(this.$route.params.orcamento_id)
        this.$store.commit('ordensServico/setItem', {})
      }
    },
    save () {
      this.$validator.validate()
        .then(result => {
          if (!result) {
            this.$q.notify({
              message: 'O registro não foi salvo, verifique os campos incorretos.',
              icon: 'fa fa-exclamation-triangle'
            })
          } else {
            this.submitting = true

            let data = {
              endereco: this.selectClientesEnderecos.value,
              empresa_id: this.selectEmpresa.value,
              transportador_id: this.selectTransportadores.value,
              data_coleta: this.data_coleta.split('/').reverse().join('-'),
              hora_coleta: this.model.hora_coleta,
              valor: this.model.valor,
              desconto: this.model.desconto,
              numero_coletas: this.selectColetas.value,
              status: this.selectStatusOptions.value,
              observacoes_poscoleta: this.model.observacoes_poscoleta,
              ordem_compra: this.model.ordem_compra,
              tipo_reservatorio: this.selectTipoReservatorios.value,
              ponto_coleta: this.selectColetas.value,
              metragem_mangueira: this.model.metragem_mangueira,
              situacao_tampas: this.model.situacao_tampas,
              situacao_efluentes: this.selectSituacaoEfluentes.value,
              observacoes: this.model.observacoes,
              horas_trabalhadas: this.model.horas_trabalhadas,
              checagem_final: this.selectChecagemFinal.value,
              faturada: this.selectFaturada.value,
              orcamento_id: this.$route.params.orcamento_id,
              observacao_faturamento: this.model.observacao_faturamento
            }
            if (this.action === 'edit') {
              // .log(data)
              this.$store.dispatch('ordensServico/updateItem', {
                data: data,
                id: this.id
              })
            } else {
            //  console.log(data)
              this.$store.dispatch('ordensServico/saveItem', data).then(() => {
                this.$router.push({
                  name: 'ordens-servico.editar',
                  params: { id: this.$store.state.ordensServico.currentId }
                })
              })
            }
            this.$validator.reset()
            this.submitting = false
          }
        })
    }
  },
  computed: {
    model () {
      return this.$store.state.ordensServico.item
    }
    // enderecos () {
    //   return _.orderBy(this.$store.state.clientesEnderecos.list.map(
    //     data =>
    //       ({
    //         label: data.endereco,
    //         value: data.id
    //       })
    //   ), 'label', 'ASC')
    // },
    // empresas () {
    //   return _.orderBy(this.$store.state.empresas.list.map(
    //     data =>
    //       ({
    //         label: data.razao_social,
    //         value: data.id
    //       })
    //   ), 'label', 'ASC')
    // },
    // transportadores () {
    //   return _.orderBy(this.$store.state.transportadores.list.map(
    //     data =>
    //       ({
    //         label: data.razao_social,
    //         value: data.id
    //       })
    //   ), 'label', 'ASC')
    // },
    // numero_coletas () {
    //   return _.orderBy(this.$store.state.ordensServico.coletasOptions.map(
    //     data =>
    //       ({
    //         label: data.label,
    //         value: data.value
    //       })
    //   ), 'label', 'ASC')
    // },
    // status () {
    //   return _.orderBy(this.$store.state.ordensServico.statusOptions.map(
    //     data =>
    //       ({
    //         label: data.label,
    //         value: data.value
    //       })
    //   ), 'label', 'ASC')
    // },
    // tipo_reservatorio () {
    //   return _.orderBy(this.$store.state.ordensServico.tipoReservatorio.map(
    //     data =>
    //       ({
    //         label: data.label,
    //         value: data.value
    //       })
    //   ), 'label', 'ASC')
    // },
    // ponto_coleta () {
    //   return _.orderBy(this.$store.state.ordensServico.acesso.map(
    //     data =>
    //       ({
    //         label: data.label,
    //         value: data.value
    //       })
    //   ), 'label', 'ASC')
    // },
    // situacao_efluentes () {
    //   return _.orderBy(this.$store.state.ordensServico.situacaoEfluentes.map(
    //     data =>
    //       ({
    //         label: data.label,
    //         value: data.value
    //       })
    //   ), 'label', 'ASC')
    // },
    // checagem_final () {
    //   return _.orderBy(this.$store.state.ordensServico.checagemFinal.map(
    //     data =>
    //       ({
    //         label: data.label,
    //         value: data.value
    //       })
    //   ), 'label', 'ASC')
    // }
    // faturada () {
    //   return _.orderBy(this.$store.state.ordensServico.faturado.map(
    //     data =>
    //       ({
    //         label: data.label,
    //         value: data.value
    //       })
    //   ), 'label', 'ASC')
    // }
  },
  mounted () {
    this.getData()
    this.$store.dispatch('clientesEnderecos/loadList',
      {
        limit: 30
        // where: {
        //   cliente_id: this.model.ordem_servico.orcamento.cliente_id
        // }
      }).then((data) => {
      this.clientesEnderecos = data.data.map(data => {
        if (parseInt(data.id) === parseInt(this.model.endereco_id)) {
          this.selectClientesEnderecos.value = data.id
          this.selectClientesEnderecos.label = data.endereco + ' ' + data.numero + ' - ' + data.bairro
        }
        return {
          label: data.endereco + ' ' + data.numero + ' - ' + data.bairro,
          value: data.id
        }
      }
      )
    })
    this.$store.dispatch('empresas/loadList',
      {
        limit: 30
        // where: {
        //   cliente_id: this.model.ordem_servico.orcamento.cliente_id
        // }
      }).then((data) => {
      this.empresa = data.data.map(data => {
        if (parseInt(data.id) === parseInt(this.model.empresa_id)) {
          this.selectEmpresa.value = data.id
          this.selectEmpresa.label = data.razao_social
        }
        return {
          label: data.razao_social,
          value: data.id
        }
      }
      )
    })
    this.$store.dispatch('transportadores/loadList',
      {
        limit: 30
        // where: {
        //   cliente_id: this.model.ordem_servico.orcamento.cliente_id
        // }
      }).then((data) => {
      this.transportadores = data.data.map(data => {
        if (parseInt(data.id) === parseInt(this.model.transportador_id)) {
          this.selectTransportadores.value = data.id
          this.selectTransportadores.label = data.razao_social
        }
        return {
          label: data.razao_social,
          value: data.id
        }
      })
    })

    this.statusOptions = this.$store.state.ordensServico.statusOptions.map(data => {
      if (parseInt(data.value) === parseInt(this.model.status)) {
        this.selectStatusOptions.value = data.value
        this.selectStatusOptions.label = data.label
      }
      return {
        label: data.label,
        value: data.value
      }
    })

    this.coletas = this.$store.state.ordensServico.coletasOptions.map(data => {
      if (parseInt(data.value) === parseInt(this.model.numero_coletas)) {
        this.selectColetas.value = data.value
        this.selectColetas.label = data.label
      }
      return {
        label: data.label,
        value: data.value
      }
    })

    this.tipoReservatorios = this.$store.state.ordensServico.tipoReservatorio.map(data => {
      if (data.value === this.model.tipo_reservatorio) {
        this.selectTipoReservatorios.value = data.value
        this.selectTipoReservatorios.label = data.label
      }
      return {
        label: data.label,
        value: data.value
      }
    })

    this.situacaoEfluentes = this.$store.state.ordensServico.situacaoEfluentes.map(data => {
      if (data.value === this.model.situacao_efluentes) {
        this.selectSituacaoEfluentes.value = data.value
        this.selectSituacaoEfluentes.label = data.label
      }
      return {
        label: data.label,
        value: data.value
      }
    })

    this.checagemFinal = this.$store.state.ordensServico.checagemFinal.map(data => {
      if (data.value === this.model.checagem_final) {
        this.selectChecagemFinal.value = data.value
        this.selectChecagemFinal.label = data.label
      }
      return {
        label: data.label,
        value: data.value
      }
    })

    this.faturada = this.$store.state.ordensServico.faturado.map(data => {
      if (data.value === this.model.faturado) {
        this.selectFaturada.value = data.value
        this.selectFaturada.label = data.label
      }
      return {
        label: data.label,
        value: data.value
      }
    })
    this.data_coleta = moment(this.model.data_emissao).format('DD/MM/YYYY')
    // console.log(this.model)
  }
}
</script>

<style>
</style>
