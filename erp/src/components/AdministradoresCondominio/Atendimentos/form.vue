<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-md-6 col-xs-12">
            <q-select
              :options="funcionario"
              v-model="model.funcionario"
              label="Funcionário"
              data-vv-name="funcionario"
              v-validate="'required'"
              :error="errors.has('funcionario')"
              :error-message="errors.first('funcionario')"
            />
          </div>
          <div class="col col-md-3 col-xs-12">
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
          <div class="col col-md-3 col-xs-12">
            <q-select
              :options="status"
              v-model="model.status"
              label="Status do Atendimento"
              data-vv-name="status"
              v-validate="'required'"
              :error="errors.has('status')"
              :error-message="errors.first('status')"
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
              @click="$router.push({name:'administradores-condominio.index'})"
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
  QSelect,
  QBtn,
  QIcon,
  QPopupProxy,
  QDate
} from 'quasar'
import _ from 'lodash'
import moment from 'moment'
export default {
  name: 'AdministradoresCondominioAtendimentosForm',
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
    QIcon,
    QPopupProxy,
    QDate
  },
  data: () => ({
    submitting: false
  }),
  methods: {
    getData () {
      if (this.id) {
        this.$store.dispatch('atendimento/loadItem', this.id)
      } else {
        this.$store.commit('atendimento/setItem', {})
      }
      this.$store.dispatch('funcionario/loadList', {})
      this.$store.dispatch('status/loadList', {})
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
              funcionario: this.model.funcionario,
              data: date.formatDate(this.model.data, 'YYYY-MM-DD'),
              status: this.model.status
            }
            if (this.action === 'edit') {
              this.$store.dispatch('atendimento/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('atendimento/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'administradores-condominio.editar',
                    params: { id: this.$store.state.atendimento.currentId }
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
      let store = this.$store.state.atendimento.item
      if (store.data) {
        store.data = date.formatDate(moment(store.data), 'DD/MM/YYYY')
      }
      return store
    },
    funcionario () {
      return _.orderBy(this.$store.state.funcionario.list.map(
        data =>
          ({
            label: data.funcionario,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    status () {
      return _.orderBy(this.$store.state.status.list.map(
        data =>
          ({
            label: data.status,
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
