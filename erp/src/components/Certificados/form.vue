<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-2 col-xs-12">
            <q-input
              type="number"
              v-model="model.sequencial"
              label="Sequencial"
              v-validate="'required'"
              :error="errors.has('sequencial')"
              :error-message="errors.first('sequencial')"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-input
              mask="###"
              fill-mask="0"
              reverse-fill-mask
              v-model="model.quantidade"
              label="Quantidade"
              v-validate="'required'"
              :error="errors.has('quantidade')"
              :error-message="errors.first('quantidade')"
            />
          </div>
          <div class="col col-sm-6 col-xs-12">
            <q-input
              v-model="model.cliente_nome"
              label="Cliente"
              data-vv-name="cliente"
              v-validate="'required'"
              :error="errors.has('cliente')"
              :error-message="errors.first('cliente')"
            />
          </div>
          <div class="col col-sm-6 col-xs-12">
            <q-input
              v-model="model.cliente_endereco"
              label="Endereço do Cliente"
              data-vv-name="endereco"
              v-validate="'required'"
              :error="errors.has('endereco')"
              :error-message="errors.first('endereco')"
            />
          </div>
          <div class="col col-sm-6 col-xs-12">
            <q-input
              v-model="model.cliente_cidade"
              label="Cidade do Cliente"
              data-vv-name="cidade"
              v-validate="'required'"
              :error="errors.has('cidade')"
              :error-message="errors.first('cidade')"
            />
          </div>
          <div class="col col-sm-6 col-xs-12">
            <q-input
              v-model="model.transportador_nome"
              label="Transportador"
              data-vv-name="transportador"
              v-validate="'required'"
              :error="errors.has('transportador')"
              :error-message="errors.first('transportador')"
            />
          </div>
          <div class="col col-sm-6 col-xs-12">
            <q-input
              v-model="model.transportador_endereco"
              label="Endereço do Transportador"
              data-vv-name="endereco_transp"
              v-validate="'required'"
              :error="errors.has('endereco_transp')"
              :error-message="errors.first('endereco_transp')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              v-model="model.transportador_lo"
              label="LO do Transportador"
              data-vv-name="lo_transp"
              v-validate="'required'"
              :error="errors.has('lo_transp')"
              :error-message="errors.first('lo_transp')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-select
              :options="efluente"
              v-model="selectTipoEfluente"
              label="Tipo de Efluente"
              data-vv-name="tipo_efluente"
              v-validate="'required'"
              :error="errors.has('tipo_efluente')"
              :error-message="errors.first('tipo_efluente')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              v-model="inicioTratamento"
              label="Inicio do Tratamento"
              data-vv-name="data_inicio"
              v-validate="'required'"
              :error="errors.has('data_inicio')"
              :error-message="errors.first('data_inicio')"
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
                      v-model="inicioTratamento"
                      @input="() => $refs.qDateProxy.hide()"
                    />
                  </q-popup-proxy>
                </q-icon>
              </template>
            </q-input>
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              v-model="fimTratamento"
              label="Fim do Tratamento"
              data-vv-name="data_fim"
              v-validate="'required'"
              :error="errors.has('data_fim')"
              :error-message="errors.first('data_fim')"
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
                      v-model="fimTratamento"
                      @input="() => $refs.qDateProxy.hide()"
                    />
                  </q-popup-proxy>
                </q-icon>
              </template>
            </q-input>
          </div>
        </div>
      </div>
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-xs-6">
            <q-btn
              color="negative"
              glossy
              @click="$router.push({name:'mtrs.index'})"
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
  QInput,
  QBtn,
  QSelect,
  QDate,
  QPopupProxy,
  QIcon
} from 'quasar'
import _ from 'lodash'
import moment from 'moment'
export default {
  name: 'CertificadosForm',
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
    QInput,
    QBtn,
    QSelect,
    QDate,
    QPopupProxy,
    QIcon
  },
  data: () => ({
    submitting: false,
    selectTipoEfluente: {
      label: '',
      value: ''
    },
    inicioTratamento: '',
    fimTratamento: '',
    efluente: []

  }),
  methods: {
    getData () {
      if (this.id) {
        this.$store.dispatch('certificados/loadItem', this.id)
      } else {
        this.$store.commit('certificados/setItem', {})
      }
      this.$store.dispatch('transportadores/loadList', {})
      // this.$store.dispatch('tipo_efluente/loadList', {})
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
              sequencial: this.model.sequencial,
              quantidade: this.model.quantidade,
              cliente: this.model.cliente_nome,
              endereco: this.model.cliente_endereco,
              cidade: this.model.cliente_cidade,
              transportador: this.model.transportador_nome,
              endereco_transp: this.model.transportador_endereco,
              lo_transp: this.model.transportador_lo,
              tipo_efluente: this.selectTipoEfluente.value,
              inicio_tratamento: this.inicioTratamento.split('/').reverse().join('-'),
              fim_tratamento: this.fimTratamento.split('/').reverse().join('-')
              // this.$route.params.id
            }
            if (this.action === 'edit') {
              this.$store.dispatch('certificados/updateItem', { data: data, id: this.id })
            } else {
              // console.log(this.$store.state)
              this.$store.dispatch('certificados/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'certificados.editar',
                    params: { id: this.$store.state.currentId }
                    // this.$store.state.ordensServico.currentId

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
      // console.log(this.$route.params.id)
      return this.$store.state.certificados.item
    },
    lo_transp () {
      return _.orderBy(this.$store.state.transportadores.list.map(
        data =>
          ({
            label: data.transp,
            value: data.id
          })
      ), 'label', 'ASC')
    }

  },
  mounted () {
    this.getData()
    // console.log(this.$store.state.mtrs.item)
    // console.log(this.model.certificados.inicio_tratamento)
    this.efluente = this.$store.state.efluentes.tipoEfluentes.map(data => {
      if (data.value === this.model.tipo_efluente) {
        this.selectTipoEfluente.value = data.value
        this.selectTipoEfluente.label = data.label
      }
      return {
        label: data.label,
        value: data.value
      }
    })
    this.inicioTratamento = moment(this.model.inicio_tratamento).format('DD/MM/YYYY')
    this.fimTratamento = moment(this.model.fim_tratamento).format('DD/MM/YYYY')
  }
}
</script>

<style>
</style>
