<template>
  <q-dialog v-model="showModal">
    <q-card>
      <q-toolbar
        class="bg-primary text-white"
      >
        <q-toolbar-title>
          <q-icon name="fa fa-money-bill-wave" />
          Dar Baixa
        </q-toolbar-title>
        <q-btn
          round
          glossy
          icon="fa fa-times"
          color="negative"
          size="sm"
          @click="showModal = false"
        />
      </q-toolbar>
      <q-card-section>
        <form @submit.prevent="save">
          <div class="row q-col-gutter-md">
            <div class="col col-xs-12">
              <div class="row q-col-gutter-md">
                <div class="col col-sm-4 col-xs-12 self-center">
                  Valor: {{ model.valor | currency }}
                </div>
                <div class="col col-sm-4 col-xs-12 self-center">
                  Data de Vencimento: {{ model.data_vencimento | formatDate('DD/MM/YYYY') }}
                </div>
                <div class="col col-sm-4 col-xs-12 self-center">
                  <q-btn
                    color="primary"
                    label="Preencher os Valores"
                    @click="preencherValores"
                  />
                </div>
                <div class="col col-sm-12 col-xs-12">
                  <q-input
                    prefix="R$"
                    v-model="model.valor_pago"
                    label="Valor Pago"
                    data-vv-name="Valor Pago"
                    v-validate="'required'"
                    :error="errors.has('Valor Pago')"
                    :error-message="errors.first('Valor Pago')"
                  />
                </div>
                <div class="col col-sm-12 col-xs-12">
                  <q-input
                    v-model="model.data_pagamento"
                    label="Data de Pagamento"
                    data-vv-name="Data de Pagamento"
                    v-validate="'required'"
                    :error="errors.has('Data de Pagamento')"
                    :error-message="errors.first('Data de Pagamento')"
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
                            v-model="model.data_pagamento"
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
                <div class="col col-xs-12 text-right">
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
      </q-card-section>
    </q-card>
  </q-dialog>
</template>

<script>
import {
  date,
  QInput,
  QBtn,
  QDate,
  QPopupProxy,
  QIcon,
  QDialog,
  QToolbar,
  QToolbarTitle,
  QCard,
  QCardSection
} from 'quasar'
import moment from 'moment'

export default {
  name: 'ContasReceberBaixar',
  props: [],
  components: {
    QInput,
    QBtn,
    QDate,
    QPopupProxy,
    QIcon,
    QDialog,
    QToolbar,
    QToolbarTitle,
    QCard,
    QCardSection
  },
  data: () => ({
    id: '',
    submitting: false,
    showModal: false
  }),
  methods: {
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
              valor_pago: this.model.valor_pago,
              data_pagamento: date.formatDate(this.model.data_pagamento, 'YYYY-MM-DD')
            }

            this.$store.dispatch('contasReceber/updateItem', { data: data, id: this.id })
              .then(() => {
                this.$validator.reset()
                this.submitting = false
                this.showModal = false
                this.$parent.searchList({
                  pagination: this.$parent.pagination,
                  filter: this.$parent.filter
                })
              })
          }
        })
    },
    abrirModal (id) {
      this.$store.dispatch('contasReceber/loadItem', id)
      this.id = id
      this.showModal = true
    },
    preencherValores () {
      this.model.valor_pago = this.model.valor
      this.model.data_pagamento = this.model.data_vencimento
    }
  },
  computed: {
    model () {
      let store = this.$store.state.contasReceber.item
      if (store.data_pagamento) {
        store.data_pagamento = date.formatDate(moment(store.data_pagamento), 'DD/MM/YYYY')
      }
      return store
    }
  }
}
</script>

<style>
</style>
