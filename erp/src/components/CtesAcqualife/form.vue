<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-md-2 col-xs-12">
            <q-input
              v-model="model.data"
              label="Data"
              data-vv-name="data"
              v-validate="'required'"
              :error="errors.has('data')"
              :error-message="errors.first('data')"
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
                      v-model="model.data"
                      @input="() => $refs.qDateProxy.hide()"
                    />
                  </q-popup-proxy>
                </q-icon>
              </template>
            </q-input>
          </div>
          <div class="col col-md-5 col-xs-12">
            <q-select
              :options="cfop"
              v-model="model.cfop"
              label="CFOP"
              data-vv-name="cfop"
              v-validate="'required'"
              :error="errors.has('cfop')"
              :error-message="errors.first('cfop')"
            />
          </div>
          <div class="col col-md-5 col-xs-12">
            <q-select
              :options="tomador"
              v-model="model.tomador"
              label="Tomador do Serviço"
              data-vv-name="tomador"
              v-validate="'required'"
              :error="errors.has('tomador')"
              :error-message="errors.first('tomador')"
            />
          </div>
          <div class="col-md-6 col-xs-12">
            <q-select
              :options="remetente"
              v-model="model.remetente"
              label="Remetente"
              data-vv-name="remetente"
              v-validate="'required'"
              :error="errors.has('remetente')"
              :error-message="errors.first('remetente')"
            />
          </div>
          <div class="col-md-6 col-xs-12">
            <q-select
              :options="endereco"
              v-model="model.endereco"
              label="Endereço"
              data-vv-name="endereco"
              v-validate="'required'"
              :error="errors.has('endereco')"
              :error-message="errors.first('endereco')"
            />
          </div>
          <div class="col-md-6 col-xs-12">
            <q-select
              :options="destinatario"
              v-model="model.destinatario"
              label="Destinatário"
              data-vv-name="destinatario"
              v-validate="'required'"
              :error="errors.has('destinatario')"
              :error-message="errors.first('destinatario')"
            />
          </div>
          <div class="col-md-6 col-xs-12">
            <q-select
              :options="endereco_destinatario"
              v-model="model.endereco_destinatario"
              label="Endereço Destinatário"
              data-vv-name="endereco_destinatario"
              v-validate="'required'"
              :error="errors.has('endereco_destinatario')"
              :error-message="errors.first('endereco_destinatario')"
            />
          </div>
          <div class="col-md-6 col-xs-12">
            <q-select
              :options="expedidor"
              v-model="model.expedidor"
              label="Expedidor"
              data-vv-name="expedidor"
              v-validate="'required'"
              :error="errors.has('expedidor')"
              :error-message="errors.first('expedidor')"
            />
          </div>
          <div class="col-md-6 col-xs-12">
            <q-select
              :options="endereco_expedidor"
              v-model="model.endereco_expedidor"
              label="Endereço Expedidor"
              data-vv-name="endereco_expedidor"
              v-validate="'required'"
              :error="errors.has('endereco_expedidor')"
              :error-message="errors.first('endereco_expedidor')"
            />
          </div>
          <div class="col-md-6 col-xs-12">
            <q-select
              :options="recebedor"
              v-model="model.recebedor"
              label="Recebedor"
              data-vv-name="recebedor"
              v-validate="'required'"
              :error="errors.has('recebedor')"
              :error-message="errors.first('recebedor')"
            />
          </div>
          <div class="col-md-6 col-xs-12">
            <q-select
              :options="endereco_recebedor"
              v-model="model.endereco_recebedor"
              label="Endereço Recebedor"
              data-vv-name="endereco_recebedor"
              v-validate="'required'"
              :error="errors.has('endereco_recebedor')"
              :error-message="errors.first('endereco_recebedor')"
            />
          </div>
          <div class="col col-md-2 col-xs-12">
            <q-input
              v-model="model.rtnrc"
              label="RTNRC"
              data-vv-name="rtnrc"
              v-validate="'required'"
              :error="errors.has('rtnrc')"
              :error-message="errors.first('rtnrc')"
            />
          </div>
          <div class="col col-md-2 col-xs-12">
            <q-input
              v-model="model.volume"
              label="Volume (m³)"
              data-vv-name="volume"
              v-validate="'required'"
              :error="errors.has('volume')"
              :error-message="errors.first('volume')"
            />
          </div>
          <div class="col col-md-8 col-xs-12">
            <q-input
              v-model="model.obs"
              label="Observações"
              data-vv-name="obs"
              v-validate="'required'"
              :error="errors.has('obs')"
              :error-message="errors.first('obs')"
            />
          </div>
          <div class="col col-md-3 col-xs-12">
            <q-select
              :options="ori_tipo"
              v-model="model.ori_tipo"
              label="Documentos Originários - Tipo"
              data-vv-name="ori_tipo"
              v-validate="'required'"
              :error="errors.has('ori_tipo')"
              :error-message="errors.first('ori_tipo')"
            />
          </div>
          <div class="col col-md-4 col-xs-12">
            <q-input
              v-model="model.ori_numero"
              label="Documentos Originários - Número"
              data-vv-name="ori_numero"
              v-validate="'required'"
              :error="errors.has('ori_numero')"
              :error-message="errors.first('ori_numero')"
            />
          </div>
          <div class="col col-md-5 col-xs-12">
            <q-input
              v-model="model.ori_descricao"
              label="Documentos Originários - Descrição"
              data-vv-name="ori_descricao"
              v-validate="'required'"
              :error="errors.has('ori_descricao')"
              :error-message="errors.first('ori_descricao')"
            />
          </div>
          <div class="col col-md-3 col-xs-12">
            <q-input
              v-model="model.emissao"
              label="Data Emissão"
              data-vv-name="emissao"
              v-validate="'required'"
              :error="errors.has('emissao')"
              :error-message="errors.first('emissao')"
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
                      v-model="model.emissao"
                      @input="() => $refs.qDateProxy.hide()"
                    />
                  </q-popup-proxy>
                </q-icon>
              </template>
            </q-input>
          </div>
          <div class="col col-md-3 col-xs-12">
            <q-input
              v-model="model.ori_valor"
              label="Documentos Originários - Valor"
              data-vv-name="ori_valor"
              v-validate="'required'"
              :error="errors.has('ori_valor')"
              :error-message="errors.first('ori_valor')"
            />
          </div>
          <div class="col col-md-6 col-xs-12">
            <q-input
              v-model="model.chave"
              label="NFE - Chave"
              data-vv-name="chave"
              v-validate="'required'"
              :error="errors.has('chave')"
              :error-message="errors.first('chave')"
            />
          </div>
          <div class="col col-md-6 col-xs-12">
            <q-input
              v-model="model.pin"
              label="NFE - PIN"
              data-vv-name="pin"
              v-validate="'required'"
              :error="errors.has('pin')"
              :error-message="errors.first('pin')"
            />
          </div>
          <div class="col col-md-3 col-xs-12">
            <q-input
              v-model="model.previsao"
              label="NFE - Data Previsão"
              data-vv-name="previsao"
              v-validate="'required'"
              :error="errors.has('previsao')"
              :error-message="errors.first('previsao')"
            />
          </div>
          <div class="col col-md-3 col-xs-12">
            <q-input
              v-model="model.valor"
              label="Valor da Carga"
              data-vv-name="valor"
              v-validate="'required'"
              :error="errors.has('valor')"
              :error-message="errors.first('valor')"
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
              @click="$router.push({name:'usuarios.index'})"
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
  date,
  QBtn,
  QInput,
  QSelect,
  QIcon,
  QPopupProxy,
  QDate
} from 'quasar'
import _ from 'lodash'
import moment from 'moment'
export default {
  name: 'CtesAcqualifeForm',
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
    QPopupProxy,
    QDate
  },
  data: () => ({
    submitting: false
  }),
  methods: {
    getData () {
      if (this.id) {
        this.$store.dispatch('ctesAcqualife/loadItem', this.id)
      } else {
        this.$store.commit('ctesAcqualife/setItem', {})
      }
      this.$store.dispatch('cfop/loadList', {})
      this.$store.dispatch('tomador/loadList', {})
      this.$store.dispatch('remetente/loadList', {})
      this.$store.dispatch('endereco/loadList', {})
      this.$store.dispatch('destinatario/loadList', {})
      this.$store.dispatch('enderecoDestinatario/loadList', {})
      this.$store.dispatch('expedidor/loadList', {})
      this.$store.dispatch('enderecoExpedidor/loadList', {})
      this.$store.dispatch('recebedor/loadList', {})
      this.$store.dispatch('enderecoRecebedor/loadList', {})
      this.$store.dispatch('oriTipo/loadList', {})
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
              data: date.formatDate(this.model.data, 'YYYY-MM-DD'),
              cfop: this.model.cfop,
              tomador: this.model.tomador,
              remetente: this.model.remetente,
              endereco: this.model.endereco,
              destinatario: this.model.destinatario,
              endereco_destinatario: this.model.endereco_destinatario,
              expedidor: this.model.expedidor,
              endereco_expedidor: this.model.endereco_expedidor,
              recebedor: this.model.recebedor,
              endereco_recebedor: this.model.endereco_recebedor,
              rtnrc: this.model.rtnrc,
              volume: this.model.volume,
              obs: this.model.obs,
              ori_tipo: this.model.ori_tipo,
              ori_numero: this.model.ori_numero,
              ori_descricao: this.model.ori_descricao,
              emissao: date.formatDate(this.model.emissao, 'YYYY-MM-DD'),
              ori_valor: this.model.ori_valor,
              chave: this.model.chave,
              pin: this.model.pin,
              previsao: this.model.previsao,
              valor: this.model.valor
            }
            if (this.action === 'edit') {
              this.$store.dispatch('ctesAcqualife/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('ctesAcqualife/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'usuarios.editar',
                    params: { id: this.$store.state.ctesAcqualife.currentId }
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
      let store = this.$store.state.ctesAcqualife.item
      if (store.data) {
        store.data = date.formatDate(moment(store.data), 'DD/MM/YYYY')
      }
      if (store.emissao) {
        store.emissao = date.formatDate(moment(store.emissao), 'DD/MM/YYYY')
      }
      return store
    },
    cfop () {
      return _.orderBy(this.$store.state.cfop.list.map(
        data =>
          ({
            label: data.cfop,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    tomador () {
      return _.orderBy(this.$store.state.tomador.list.map(
        data =>
          ({
            label: data.tomador,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    remetente () {
      return _.orderBy(this.$store.state.remetente.list.map(
        data =>
          ({
            label: data.remetente,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    endereco () {
      return _.orderBy(this.$store.state.endereco.list.map(
        data =>
          ({
            label: data.endereco,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    destinatario () {
      return _.orderBy(this.$store.state.destinatario.list.map(
        data =>
          ({
            label: data.destinatario,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    enderecoDestinatario () {
      return _.orderBy(this.$store.state.enderecoDestinatario.list.map(
        data =>
          ({
            label: data.enderecoDestinatario,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    expedidor () {
      return _.orderBy(this.$store.state.expedidor.list.map(
        data =>
          ({
            label: data.expedidor,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    enderecoExpedidor () {
      return _.orderBy(this.$store.state.enderecoExpedidor.list.map(
        data =>
          ({
            label: data.enderecoExpedidor,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    recebedor () {
      return _.orderBy(this.$store.state.recebedor.list.map(
        data =>
          ({
            label: data.recebedor,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    enderecoRecebedor () {
      return _.orderBy(this.$store.state.enderecoRecebedor.list.map(
        data =>
          ({
            label: data.enderecoRecebedor,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    oriTipo () {
      return _.orderBy(this.$store.state.oriTipo.list.map(
        data =>
          ({
            label: data.oriTipo,
            value: data.id
          })
      ), 'label', 'ASC')
    }
  },
  mounted () {
    this.getData()
  }
}
</script>

<style>
</style>
