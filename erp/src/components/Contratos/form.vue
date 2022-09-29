<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-3 col-xs-12">
            <q-input
              v-model="dataAssinatura"
              label="Data de Assinatura"
              data-vv-name="data_assinatura"
              v-validate="'required'"
              :error="errors.has('data_assinatura')"
              :error-message="errors.first('data_assinatura')"
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
                      v-model="dataAssinatura"
                      @input="() => $refs.qDateProxy.hide()"
                    />
                  </q-popup-proxy>
                </q-icon>
              </template>
            </q-input>
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              v-model="dataEncerramento"
              label="Data de Vencimento"
              data-vv-name="data_encerramento"
              v-validate="'required'"
              :error="errors.has('data_encerramento')"
              :error-message="errors.first('data_encerramento')"
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
                      v-model="dataEncerramento"
                      @input="() => $refs.qDateProxy.hide()"
                    />
                  </q-popup-proxy>
                </q-icon>
              </template>
            </q-input>
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-select
              :options="servico"
              v-model="selectServicoContratado"
              label="Serviço Contratado"
              data-vv-name="servico"
              v-validate="'required'"
              :error="errors.has('servico')"
              :error-message="errors.first('servico')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-select
              :options="efluente"
              v-model="selectTipoEfluente"
              label="Tipo de Efluente"
              data-vv-name="efluente"
              v-validate="'required'"
              :error="errors.has('efluente')"
              :error-message="errors.first('efluente')"
            />
          </div>
          <div class="col col-md-12 col-xs-12">
            <q-input
              v-model="model.condicoes"
              label="Condições"
              data-vv-name="condicoes"
              v-validate="'required'"
              :error="errors.has('condicoes')"
              :error-message="errors.first('condicoes')"
            />
          </div>
          <div class="col col-md-4 col-xs-12">
            <q-input
              fill-mask="0"
              reverse-fill-mask
              prefix="R$"
              v-model="valorTransporte"
              label="Valor do Transporte"
            />
          </div>
          <div class="col col-md-4 col-xs-12">
            <q-input
              fill-mask="0"
              reverse-fill-mask
              prefix="R$"
              v-model="valorTratamento"
              label="Valor do Tratamento"
            />
          </div>
          <div class="col col-md-4 col-xs-12">
            <q-select
              :options="encerrado"
              v-model="selectEncerrado"
              label="Contrato Encerrado?"
              data-vv-name="encerrado"
              v-validate="'required'"
              :error="errors.has('encerrado')"
              :error-message="errors.first('encerrado')"
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
              @click="$router.push({name:'contratos.index'})"
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
  QInput,
  QSelect,
  QIcon,
  QPopupProxy
} from 'quasar'
import moment from 'moment'

export default {
  name: 'ContratosForm',
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
    QInput,
    QSelect,
    QIcon,
    QPopupProxy
  },
  data: () => ({
    submitting: false,
    efluente: [],
    encerrado: [],
    servico: [],
    selectServicoContratado: {
      label: '',
      value: ''
    },
    selectTipoEfluente: {
      label: '',
      value: ''
    },
    selectEncerrado: {
      label: '',
      value: ''
    },
    dataAssinatura: '',
    dataEncerramento: '',
    valorTratamento: '',
    valorTransporte: ''
  }),
  methods: {
    formatPrice (value) {
      let val = (value / 1).toFixed(2).replace('.', ',')
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')
    },
    getData () {
      if (this.id) {
        this.$store.dispatch('contratos/loadItem', this.id)
      } else {
        this.$store.commit('contratos/setItem', {})
      }
      // this.$store.dispatch('servico/loadList', {})
      // this.$store.dispatch('efluente/loadList', {})
      // this.$store.dispatch('encerrado/loadList', {})
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

              data_assinatura: this.dataAssinatura.split('/').reverse().join('-'),
              data_encerramento: this.dataEncerramento.split('/').reverse().join('-'),
              servico: this.selectServicoContratado.value,
              efluente: this.selectTipoEfluente.value,
              condicoes: this.model.condicoes,
              valor_transp: this.valorTransporte.replace(/[^0-9,]*/g, '').replace(',00', '.').replace('.', ''),
              valor_tratamento: this.valorTratamento.replace(/[^0-9,]*/g, '').replace(',00', '.').replace('.', ''),
              encerrado: this.selectEncerrado.value
            }
            if (this.action === 'edit') {
              this.$store.dispatch('contratos/updateItem', { data: data, id: this.id })
              console.log(data)
            } else {
              this.$store.dispatch('contratos/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'contratos.editar',
                    params: { id: this.$store.state.contratos.currentId }
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
      let store = this.$store.state.contratos.item
      return store
    }

  },
  mounted () {
    this.getData()

    this.servico = this.$store.state.servicos.servicosContratado.map(data => {
      if (parseInt(data.value) === this.model.servico_contratado) {
        this.selectServicoContratado.value = data.value
        this.selectServicoContratado.label = data.label
      }
      return {
        label: data.label,
        value: data.value
      }
    })
    this.efluente = this.$store.state.efluentes.tipos.map(data => {
      if (parseInt(data.value) === this.model.tipo_efluente) {
        this.selectTipoEfluente.value = data.value
        this.selectTipoEfluente.label = data.label
      }
      return {
        label: data.label,
        value: data.value
      }
    })
    this.encerrado = this.$store.state.servicos.encerrado.map(data => {
      if (data.value === this.model.acabado) {
        this.selectEncerrado.value = data.value
        this.selectEncerrado.label = data.label
      }
      return {
        label: data.label,
        value: data.value
      }
    })
    this.dataAssinatura = moment(this.model.data_assinatura).format('DD/MM/YYYY')
    this.dataEncerramento = moment(this.model.data_encerramento).format('DD/MM/YYYY')
    this.valorTratamento = this.formatPrice(this.model.valor_tratamento)
    this.valorTransporte = this.formatPrice(this.model.valor_transporte)
  }
}
</script>

<style>
</style>
