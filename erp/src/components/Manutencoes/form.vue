<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-6 col-xs-12">
            <q-select
              filter
              :options="fornecedores"
              v-model="model.fornecedor_id"
              label="Fornecedor"
              data-vv-name="Fornecedor"
              v-validate="'required'"
              :error="errors.has('Fornecedor')"
              :error-message="errors.first('Fornecedor')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              v-model="model.data"
              label="Data"
              data-vv-name="Data"
              v-validate="'required'"
              :error="errors.has('Data')"
              :error-message="errors.first('Data')"
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
          <div class="col col-sm-3 col-xs-12">
            <q-input
              prefix="R$"
              v-model="model.valor"
              label="Valor"
              data-vv-name="Valor"
              v-validate="'required'"
              :error="errors.has('Valor')"
              :error-message="errors.first('Valor')"
            />
          </div>
          <div class="col col-sm-12 col-xs-12">
            <q-input
              type="textarea"
              rows="5"
              v-model="model.observacoes"
              label="Observações"
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
              @click="$router.push({name:'manutencoes.index'})"
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
  date
} from 'quasar'
import _ from 'lodash'
import moment from 'moment'

export default {
  name: 'ManutencoesForm',
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
    QPopupProxy
  },
  data: () => ({
    submitting: false
  }),
  methods: {
    getData () {
      if (this.id) {
        this.$store.dispatch('manutencoes/loadItem', this.id)
      } else {
        this.$store.commit('manutencoes/setItem', {})
      }
      this.$store.dispatch('fornecedores/loadList', {})
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
              fornecedor_id: this.model.fornecedor_id,
              data: date.formatDate(this.model.data, 'YYYY-MM-DD'),
              valor: this.model.valor,
              observacoes: this.model.observacoes
            }
            if (this.action === 'edit') {
              this.$store.dispatch('manutencoes/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('manutencoes/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'manutencoes.editar',
                    params: { id: this.$store.state.manutencoes.currentId }
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
      let store = this.$store.state.manutencoes.item
      if (store.data) {
        store.data = date.formatDate(moment(store.data), 'DD/MM/YYYY')
      }
      return store
    },
    fornecedores () {
      return _.orderBy(this.$store.state.fornecedores.list.map(
        data =>
          ({
            label: data.razao_social,
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
