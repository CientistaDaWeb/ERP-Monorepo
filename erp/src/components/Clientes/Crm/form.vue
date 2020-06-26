<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-sm-12 col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-4 col-xs-12">
            <q-select
              filter
              v-model="model.usuario_id"
              :options="usuarios"
              label="Funcionário"
              data-vv-name="Funcionário"
              v-validate="'required'"
              :error="errors.has('Funcionário')"
              :error-message="errors.first('Funcionário')"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
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
          <div class="col col-sm-4 col-xs-12">
            <q-select
              filter
              v-model="model.status"
              :options="statusOptions"
              label="Status do Atendimento"
              data-vv-name="Status do Atendimento"
              v-validate="'required'"
              :error="errors.has('Status do Atendimento')"
              :error-message="errors.first('Satus do Atendimento')"
            />
          </div>
          <div class="col col-sm-12 col-xs-12">
            <q-input
              type="textarea"
              rows="5"
              v-model="model.descricao"
              label="Descrição"
              data-vv-name="Descrição"
              v-validate="'required'"
              :error="errors.has('Descrição')"
              :error-message="errors.first('Descrição')"
            />
          </div>
        </div>
      </div>
      <div class="col col-sm-12 col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-xs-6">
            <q-btn
              color="negative"
              glossy
              @click="$router.push({name:'clientes.editar', params: {id: cliente_id, view: 'atendimentos'}})"
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
  name: 'ClientesCrmForm',
  props: {
    clienteId: {
      type: Number,
      required: true
    },
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
        this.$store.dispatch('clientesCrm/loadItem', this.id)
      } else {
        this.$store.commit('clientesCrm/setItem', {})
      }
      this.$store.dispatch('usuarios/loadList', {
        where: {
          ativo: 'S'
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
              cliente_id: this.cliente_id,
              usuario_id: this.model.usuario_id,
              data: date.formatDate(this.model.data, 'YYYY-MM-DD'),
              descricao: this.model.descricao,
              status: this.model.status
            }
            if (this.action === 'edit') {
              this.$store.dispatch('clientesCrm/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('clientesCrm/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'clientes.editar',
                    params: { id: this.cliente_id, view: 'atendimentos' }
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
      let store = this.$store.state.clientesCrm.item
      if (store.data) {
        store.data = date.formatDate(moment(store.data), 'DD/MM/YYYY')
      }
      return store
    },
    usuarios () {
      return _.orderBy(this.$store.state.usuarios.list.map(d =>
        ({
          label: d.nome,
          value: d.id
        })
      ), 'label')
    },
    statusOptions () {
      return this.$store.state.clientesCrm.statusOptions
    }
  },
  mounted () {
    this.getData()
  }
}
</script>
