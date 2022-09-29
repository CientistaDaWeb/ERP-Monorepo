<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-md-5 col-xs-12">
            <q-select
              :options="ususario"
              v-model="model.ususario"
              label="Usuário"
              data-vv-name="ususario"
              v-validate="'required'"
              :error="errors.has('ususario')"
              :error-message="errors.first('ususario')"
            />
          </div>
          <div class="col col-md-7 col-xs-12">
            <q-select
              :options="cliente"
              v-model="model.cliente"
              label="Cliente"
              data-vv-name="cliente"
              v-validate="'required'"
              :error="errors.has('cliente')"
              :error-message="errors.first('cliente')"
            />
          </div>
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
          <div class="col col-md-6 col-xs-12">
            <q-input
              v-model="model.local"
              label="Local"
              data-vv-name="local"
              :error="errors.has('local')"
              :error-message="errors.first('local')"
            />
          </div>
          <div class="col col-md-12 col-xs-12">
            <q-input
              type="textarea"
              rows="3"
              v-model="model.descricao"
              label="Descrição"
              data-vv-name="descricao"
              v-validate="'required'"
              :error="errors.has('descricao')"
              :error-message="errors.first('descricao')"
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
              v-model="model.hora"
              label="Hora"
              data-vv-name="hora"
              v-validate="'required'"
              :error="errors.has('hora')"
              :error-message="errors.first('hora')"
            />
          </div>
          <div class="col col-md-2 col-xs-12">
            <q-select
              :options="status2"
              v-model="model.status"
              label="Status"
              data-vv-name="status"
              v-validate="'required'"
              :error="errors.has('status')"
              :error-message="errors.first('status')"
            />
          </div>
          <div class="col col-md-4 col-xs-12">
            <q-input
              type="number"
              v-model="model.repetir"
              label="Repetir quantas vezes?"
              data-vv-name="repetir"
              v-validate="'required'"
              :error="errors.has('repetir')"
              :error-message="errors.first('repetir')"
            />
          </div>
          <div class="col col-md-2 col-xs-12">
            <q-select
              :options="status2"
              v-model="model.status2"
              label="Status"
              data-vv-name="status2"
              v-validate="'required'"
              :error="errors.has('status2')"
              :error-message="errors.first('status2')"
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
              @click="$router.push({name:'agenda.index'})"
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
  QDate,
  QIcon,
  QPopupProxy
} from 'quasar'
import _ from 'lodash'
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
    QSelect,
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
        this.$store.dispatch('agenda/loadItem', this.id)
      } else {
        this.$store.commit('agenda/setItem', {})
      }
      this.$store.dispatch('ususario/loadList', {})
      this.$store.dispatch('cliente/loadList', {})
      this.$store.dispatch('status2/loadList', {})
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
              ususario: this.model.ususario,
              cliente: this.model.cliente,
              titulo: this.model.titulo,
              local: this.model.local,
              descricao: this.model.descricao,
              data: date.formatDate(this.model.data, 'YYYY-MM-DD'),
              hora: this.model.hora,
              status: this.model.status,
              repetir: this.model.repetir,
              status2: this.model.status2
            }
            if (this.action === 'edit') {
              this.$store.dispatch('agenda/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('agenda/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'agenda.editar',
                    params: { id: this.$store.state.transportadores.currentId }
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
      let store = this.$store.state.agenda.item
      if (store.data) {
        store.data = date.formatDate(moment(store.data), 'DD/MM/YYYY')
      }
      return store
    },
    ususario () {
      return _.orderBy(this.$store.state.usuario.list.map(
        data =>
          ({
            label: data.usuario,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    cliente () {
      return _.orderBy(this.$store.state.cliente.list.map(
        data =>
          ({
            label: data.cliente,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    status2 () {
      return _.orderBy(this.$store.state.status2.list.map(
        data =>
          ({
            label: data.status2,
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
