<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-6 col-xs-12">
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
          <div class="col col-sm-6 col-xs-12">
            <q-select
              filter
              :options="categorias"
              v-model="model.categoria_id"
              label="Categoria"
              data-vv-name="Categoria"
              v-validate="'required'"
              :error="errors.has('Categoria')"
              :error-message="errors.first('Categoria')"
            />
          </div>
          <div class="col col-sm-6 col-xs-12">
            <q-select
              filter
              :options="formasPagamento"
              v-model="model.forma_pagamento_id"
              label="Forma de Pagamento"
              data-vv-name="Forma de Pagamento"
              v-validate="'required'"
              :error="errors.has('Forma de Pagamento')"
              :error-message="errors.first('Forma de Pagamento')"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-select
              filter
              :options="contaFixa"
              v-model="model.conta_fixa"
              label="Conta Fixa?"
              data-vv-name="Conta Fixa?"
              v-validate="'required'"
              :error="errors.has('Conta Fixa?')"
              :error-message="errors.first('Conta Fixa?')"
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
              :error-message="errors.first('valor')"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-input
              v-model="model.data_vencimento"
              label="Data de Vencimento"
              data-vv-name="Data de Vencimento"
              v-validate="'required'"
              :error="errors.has('Data de Vencimento')"
              :error-message="errors.first('Data de Vencimento')"
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
              @click="$router.push({name:'contas-pagar.index'})"
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
  QInput,
  QBtn,
  QSelect,
  QDate,
  QPopupProxy
} from 'quasar'
import _ from 'lodash'
import moment from 'moment'

export default {
  name: 'ContasPagarForm',
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
        this.$store.dispatch('contasPagar/loadItem', this.id)
      } else {
        this.$store.commit('contasPagar/setItem', {})
      }
      this.$store.dispatch('empresas/loadList', {})
      this.$store.dispatch('fornecedores/loadList', {})
      this.$store.dispatch('contasPagarCategorias/loadList', {})
      this.$store.dispatch('formasPagamento/loadList', {})
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
              fornecedor_id: this.model.fornecedor_id,
              categoria_id: this.model.categoria_id,
              forma_pagamento_id: this.model.forma_pagamento_id,
              conta_fixa: this.model.conta_fixa,
              valor: this.model.valor,
              data_vencimento: date.formatDate(this.model.data_vencimento, 'YYYY-MM-DD'),
              observacoes: this.model.observacoes
            }
            if (this.action === 'edit') {
              this.$store.dispatch('contasPagar/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('contasPagar/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'contas-pagar.editar',
                    params: { id: this.$store.state.contasPagar.currentId }
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
      let store = this.$store.state.contasPagar.item
      if (store.data_vencimento) {
        store.data_vencimento = date.formatDate(moment(store.data_vencimento), 'DD/MM/YYYY')
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
    fornecedores () {
      return _.orderBy(this.$store.state.fornecedores.list.map(
        data =>
          ({
            label: data.razao_social,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    categorias () {
      return _.orderBy(this.$store.state.contasPagarCategorias.list.map(
        data =>
          ({
            label: data.categoria,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    formasPagamento () {
      return _.orderBy(this.$store.state.formasPagamento.list.map(
        data =>
          ({
            label: data.banco.banco + ' - ' + data.forma_pagamento,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    contaFixa () {
      return this.$store.state.contasPagar.contaFixa
    }
  },
  mounted () {
    this.getData()
  }
}
</script>

<style>
</style>
