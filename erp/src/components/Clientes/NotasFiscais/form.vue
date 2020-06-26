<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-5 col-xs-12">
            <q-select
              filter
              :options="empresas"
              v-model="model.empresa_id"
              label="Empresa"
              data-vv-name="Empresa"
              v-validate="'required'"
              :error="errors.has('Empresa')"
              :error-message="errors.first('Empresa')"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-select
              :options="tipos"
              v-model="model.tipo"
              label="Tipo"
              data-vv-name="Tipo"
              v-validate="'required'"
              :error="errors.has('Tipo')"
              :error-message="errors.first('Tipo')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              v-model="model.data_geracao"
              label="Data de Emissão"
              data-vv-name="Data de Emissão"
              v-validate="'required'"
              :error="errors.has('Data de Emissão')"
              :error-message="errors.first('Data de Emissão')"
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
                      v-model="model.data_geracao"
                      @input="() => $refs.qDateProxy.hide()"
                    />
                  </q-popup-proxy>
                </q-icon>
              </template>
            </q-input>
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-input
              type="number"
              v-model="model.numero"
              label="Número"
              data-vv-name="Número"
              v-validate="'required'"
              :error="errors.has('Número')"
              :error-message="errors.first('Número')"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
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
          <div class="col col-sm-4 col-xs-12">
            <q-input
              prefix="R$"
              v-model="model.valor_retido"
              label="Valor Retido"
              data-vv-name="Valor Retido"
              v-validate="'required'"
              :error="errors.has('Valor Retido')"
              :error-message="errors.first('Valor Retido')"
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
              @click="$router.push({name:'notas-fiscais.index'})"
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
  QSelect,
  date
} from 'quasar'
import _ from 'lodash'
import moment from 'moment'

export default {
  name: 'NotasFiscaisForm',
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
    QPopupProxy,
    QSelect
  },
  data: () => ({
    submitting: false
  }),
  methods: {
    getData () {
      if (this.id) {
        this.$store.dispatch('notasFiscais/loadItem', this.id)
      } else {
        this.$store.commit('notasFiscais/setItem', {})
      }
      this.$store.dispatch('empresas/loadList', {})
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
              empresa_id: this.model.empresa_id,
              data_geracao: date.formatDate(this.model.data_geracao, 'YYYY-MM-DD'),
              cliente: this.model.cliente,
              numero: this.model.numero,
              valor: this.model.valor,
              valor_retido: this.model.valor_retido,
              tipo: this.model.tipo
            }
            if (this.action === 'edit') {
              this.$store.dispatch('notasFiscais/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('notasFiscais/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'notasFiscais.editar',
                    params: { id: this.$store.state.notasFiscais.currentId }
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
      let store = this.$store.state.notasFiscais.item
      if (store.data_geracao) {
        store.data_geracao = date.formatDate(moment(store.data_geracao), 'DD/MM/YYYY')
      }
      return store
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
    tipos () {
      return this.$store.state.notasFiscais.tipos
    }
  },
  mounted () {
    this.getData()
  }
}
</script>

<style>
</style>
