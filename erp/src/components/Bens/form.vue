<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-5 col-xs-12">
            <q-input
              v-model="model.nome"
              label="Nome"
              data-vv-name="Nome"
              v-validate="'required'"
              :error="errors.has('Nome')"
              :error-message="errors.first('Nome')"
            />
          </div>
          <div class="col col-sm-2 col-xs-12">
            <q-input
              prefix="R$"
              v-model="model.valor_compra"
              label="Valor de Compra"
              data-vv-name="Valor de Compra"
              v-validate="'required'"
              :error="errors.has('Valor de Compra')"
              :error-message="errors.first('Valor de Compra')"
            />
          </div>
          <div class="col col-sm-2 col-xs-12">
            <q-input
              v-model="model.data_aquisicao"
              label="Data de Aquisição"
              data-vv-name="Data de Aquisição"
              v-validate="'required'"
              :error="errors.has('Data de Aquisição')"
              :error-message="errors.first('Data de Aquisição')"
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
                      v-model="model.data_aquisicao"
                      @input="() => $refs.qDateProxy.hide()"
                    />
                  </q-popup-proxy>
                </q-icon>
              </template>
            </q-input>
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              v-model="model.meses_quitacao"
              label="Meses para retorno do Investimento"
              data-vv-name="Meses para retorno do Investimento"
              v-validate="'required'"
              :error="errors.has('Meses para retorno do Investimento')"
              :error-message="errors.first('Meses para retorno do Investimento')"
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
              @click="$router.push({name:'bens.index'})"
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
  QDate,
  QPopupProxy,
  date
} from 'quasar'
import moment from 'moment'

export default {
  name: 'BensForm',
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
    QDate,
    QPopupProxy
  },
  data: () => ({
    submitting: false
  }),
  methods: {
    getData () {
      if (this.id) {
        this.$store.dispatch('bens/loadItem', this.id)
      } else {
        this.$store.commit('bens/setItem', {})
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
              nome: this.model.nome,
              valor_compra: this.model.valor_compra,
              data_aquisicao: date.formatDate(this.model.data_aquisicao, 'YYYY-MM-DD'),
              meses_quitacao: this.model.meses_quitacao
            }
            if (this.action === 'edit') {
              this.$store.dispatch('bens/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('bens/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'bens.editar',
                    params: { id: this.$store.state.bens.currentId }
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
      let store = this.$store.state.bens.item
      if (store.data_aquisicao) {
        store.data_aquisicao = date.formatDate(moment(store.data_aquisicao), 'DD/MM/YYYY')
      }
      return store
    }
  },
  mounted () {
    this.getData()
  }
}
</script>

<style>
</style>
