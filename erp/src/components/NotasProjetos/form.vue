<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-4 col-xs-12">
            <q-input
              v-model="model.data_emissao"
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
                      v-model="model.data_emissao"
                      @input="() => $refs.qDateProxy.hide()"
                    />
                  </q-popup-proxy>
                </q-icon>
              </template>
            </q-input>
          </div>
          <div class="col col-sm-8 col-xs-12">
            <q-input
              v-model="model.cliente"
              label="Cliente"
              data-vv-name="Cliente"
              v-validate="'required'"
              :error="errors.has('Cliente')"
              :error-message="errors.first('Cliente')"
            />
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
              @click="$router.push({name:'notas-projetos.index'})"
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
  name: 'NotasProjetosForm',
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
        this.$store.dispatch('notasProjetos/loadItem', this.id)
      } else {
        this.$store.commit('notasProjetos/setItem', {})
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
              data_emissao: date.formatDate(this.model.data_emissao, 'YYYY-MM-DD'),
              cliente: this.model.cliente,
              numero: this.model.numero,
              valor: this.model.valor,
              valor_retido: this.model.valor_retido
            }
            if (this.action === 'edit') {
              this.$store.dispatch('notasProjetos/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('notasProjetos/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'notas-projetos.editar',
                    params: { id: this.$store.state.notasProjetos.currentId }
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
      let store = this.$store.state.notasProjetos.item
      if (store.data_emissao) {
        store.data_emissao = date.formatDate(moment(store.data_emissao), 'DD/MM/YYYY')
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
