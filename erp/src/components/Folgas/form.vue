<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-md-6 col-xs-12">
            <q-input
              v-model="model.titulo"
              label="Título"
              data-vv-name="titulo"
              v-validate="'required'"
              :error="errors.has('titulo')"
              :error-message="errors.first('titulo')"
            />
          </div>
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
          <div class="col col-md-2 col-xs-12">
            <q-input
              type="time"
              v-model="model.hora_inicio"
              label="Hora Inicio"
              data-vv-name="hora_inicio"
              v-validate="'required'"
              :error="errors.has('hora_inicio')"
              :error-message="errors.first('hora_inicio')"
            />
          </div>
          <div class="col col-md-2 col-xs-12">
            <q-input
              type="time"
              v-model="model.hora_fim"
              label="Hora Fim"
              data-vv-name="hora_fim"
              v-validate="'required'"
              :error="errors.has('hora_fim')"
              :error-message="errors.first('hora_fim')"
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
              @click="$router.push({name:'folgas.index'})"
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
  QDate,
  QIcon,
  QPopupProxy
} from 'quasar'
import moment from 'moment'
export default {
  name: 'TransportadoresForm',
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
    QDate,
    QIcon,
    QPopupProxy
  },
  data: () => ({
    submitting: false
  }),
  methods: {
    getData () {
      if (this.id) {
        this.$store.dispatch('folgas/loadItem', this.id)
      } else {
        this.$store.commit('folgas/setItem', {})
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
              titulo: this.model.titulo,
              data: date.formatDate(this.model.data, 'YYYY-MM-DD'),
              hora_inicio: this.model.hora_inicio,
              hora_fim: this.model.hora_fim
            }
            if (this.action === 'edit') {
              this.$store.dispatch('folgas/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('folgas/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'folgas.editar',
                    params: { id: this.$store.state.agenda.currentId }
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
      let store = this.$store.state.abastecimentos.item
      if (store.data) {
        store.data = date.formatDate(moment(store.data), 'DD/MM/YYYY')
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
