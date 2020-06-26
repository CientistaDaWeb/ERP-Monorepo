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
            <q-input
              v-model="model.data_vencimento"
              label="Data de Vencimento"
              data-vv-name="Data de Vencimento"
              v-validate="'required'"
              :error="errors.has('Data Vencimento')"
              :error-message="errors.first('Data Vencimento')"
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
          <div class="col col-sm-4 col-xs-12">
            <q-input
              v-model="model.descricao"
              label="Descrição"
            />
          </div>
          <div class="col col-sm-6 col-xs-12">
            <q-select
              filter
              :options="enderecos"
              v-model="model.endereco_id"
              label="Endereço"
              data-vv-name="Endereço"
              v-validate="'required'"
              :error="errors.has('Endereço')"
              :error-message="errors.first('Endereço')"
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
              @click="$router.push({name:'contas-receber.index'})"
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
  name: 'ContasReceberForm',
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
        this.$store.dispatch('contasReceber/loadItem', this.id)
      } else {
        this.$store.commit('contasReceber/setItem', {})
      }
      this.$store.dispatch('empresas/loadList', {})
      this.$store.dispatch('formasPagamento/loadList', {})
      this.$store.dispatch('clientesEnderecos/loadList', {
        where: {
          cliente_id: this.model.orcamento.cliente_id
        }
      })
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
              orcamento_id: this.model.orcamento_id,
              forma_pagamento_id: this.model.forma_pagamento_id,
              valor: this.model.valor,
              valor_retido: this.model.valor_retido,
              data_vencimento: date.formatDate(this.model.data_vencimento, 'YYYY-MM-DD'),
              descricao: this.model.descricao,
              endereco_id: this.endereco_id,
              observacoes: this.model.observacoes
            }
            if (this.action === 'edit') {
              this.$store.dispatch('contasReceber/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('contasReceber/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'contas-receber.editar',
                    params: { id: this.$store.state.contasReceber.currentId }
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
      let store = this.$store.state.contasReceber.item
      if (store.data) {
        store.data = date.formatDate(moment(store.data), 'DD/MM/YYYY')
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
    formasPagamento () {
      return _.orderBy(this.$store.state.formasPagamento.list.map(
        data =>
          ({
            label: data.banco.banco + ' - ' + data.forma_pagamento,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    enderecos () {
      return _.orderBy(this.$store.state.clientesEnderecos.list.map(
        data =>
          ({
            label: data.endereco,
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
