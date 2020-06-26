<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-3 col-xs-12">
            <q-input
              v-model="model.data_assinatura"
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
                      v-model="model.data_assinatura"
                      @input="() => $refs.qDateProxy.hide()"
                    />
                  </q-popup-proxy>
                </q-icon>
              </template>
            </q-input>
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              v-model="model.data_vencimento"
              label="Data de Vencimento"
              data-vv-name="data_vencimento"
              v-validate="'required'"
              :error="errors.has('data_vencimento')"
              :error-message="errors.first('data_vencimento')"
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
                      v-model="model.data_vencimento"
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
              v-model="model.servico"
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
              v-model="model.efluente"
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
              mask="####.##"
              fill-mask="0"
              reverse-fill-mask
              prefix="R$"
              v-model="model.valor_transp"
              label="Valor do Transporte"
            />
          </div>
          <div class="col col-md-4 col-xs-12">
            <q-input
              mask="####.##"
              fill-mask="0"
              reverse-fill-mask
              prefix="R$"
              v-model="model.valor_tratamento"
              label="Valor do Tratamento"
            />
          </div>
          <div class="col col-md-4 col-xs-12">
            <q-select
              :options="encerrado"
              v-model="model.encerrado"
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
  date,
  QBtn,
  QInput,
  QSelect,
  QIcon,
  QPopupProxy
} from 'quasar'
import _ from 'lodash'
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
    submitting: false
  }),
  methods: {
    getData () {
      if (this.id) {
        this.$store.dispatch('contratos/loadItem', this.id)
      } else {
        this.$store.commit('contratos/setItem', {})
      }
      this.$store.dispatch('servico/loadList', {})
      this.$store.dispatch('efluente/loadList', {})
      this.$store.dispatch('encerrado/loadList', {})
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
              data_assinatura: date.formatDate(this.model.data_assinatura, 'YYYY-MM-DD'),
              data_vencimento: date.formatDate(this.model.data_vencimento, 'YYYY-MM-DD'),
              servico: this.model.servico,
              efluente: this.model.efluente,
              condicoes: this.model.condicoes,
              valor_transp: this.model.valor_transp,
              valor_tratamento: this.model.valor_tratamento,
              encerrado: this.model.encerrado
            }
            if (this.action === 'edit') {
              this.$store.dispatch('contratos/updateItem', { data: data, id: this.id })
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
      if (store.data_assinatura) {
        store.data_assinatura = date.formatDate(moment(store.data_assinatura), 'DD/MM/YYYY')
      }
      if (store.data_vencimento) {
        store.data_vencimento = date.formatDate(moment(store.data_vencimento), 'DD/MM/YYYY')
      }
      return store
    },
    servico () {
      return _.orderBy(this.$store.state.servico.list.map(
        data =>
          ({
            label: data.servico,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    efluente () {
      return _.orderBy(this.$store.state.efluente.list.map(
        data =>
          ({
            label: data.efluente,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    encerrado () {
      return _.orderBy(this.$store.state.encerrado.list.map(
        data =>
          ({
            label: data.encerrado,
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
