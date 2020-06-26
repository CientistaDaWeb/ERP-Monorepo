<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-md-6 offset-md-1 col-xs-12">
            <q-select
              :options="usuario"
              v-model="model.usuario"
              label="Usuário"
              data-vv-name="usuario"
              v-validate="'required'"
              :error="errors.has('usuario')"
              :error-message="errors.first('usuario')"
            />
          </div>
          <div class="col col-md-2 col-xs-12">
            <q-select
              :options="[8]"
              :value="8"
              v-model="model.mes"
              label="Mês"
              data-vv-name="mes"
              v-validate="'required'"
              :error="errors.has('mes')"
              :error-message="errors.first('mes')"
            />
          </div>
          <div class="col col-md-2 col-xs-12">
            <q-select
              :options="[2019]"
              :value="2019"
              v-model="model.ano"
              label="Ano"
              data-vv-name="ano"
              v-validate="'required'"
              :error="errors.has('ano')"
              :error-message="errors.first('ano')"
            />
          </div>
        </div>
        <div class="row q-col-gutter-md">
          <div class="col col-md-2 offset-md-1 col-xs-12 text-center">
            <label>Data</label>
          </div>
          <div class="col col-md-2 col-xs-12 text-center">
            <label>Entrada Manhã</label>
          </div>
          <div class="col col-md-2 col-xs-12 text-center">
            <label>Saída Manhã</label>
          </div>
          <div class="col col-md-2 col-xs-12 text-center">
            <label>Entrada Tarde</label>
          </div>
          <div class="col col-md-2 col-xs-12 text-center">
            <label>Saída Tarde</label>
          </div>
        </div>
        <div class="row q-col-gutter-md items-center">
          <template v-for="(data, index) in datas">
            <div
              class="col col-md-2 offset-md-1 col-xs-12 text-center"
              :key="index"
            >
              <label>{{ data }}</label>
            </div>
            <div
              class="col col-md-2 col-xs-12 text-center"
              :key="index"
            >
              <q-input
                v-model="model.data_entrada_manha"
                data-vv-name="data_entrada_manha"
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
                        v-model="model.data_entrada_manha"
                        @input="() => $refs.qDateProxy.hide()"
                      />
                    </q-popup-proxy>
                  </q-icon>
                </template>
              </q-input>
            </div>
            <div
              class="col col-md-2 col-xs-12 text-center"
              :key="index"
            >
              <q-input
                v-model="model.data_saida_manha"
                data-vv-name="data_saida_manha"
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
                        v-model="model.data_saida_manha"
                        @input="() => $refs.qDateProxy.hide()"
                      />
                    </q-popup-proxy>
                  </q-icon>
                </template>
              </q-input>
            </div>
            <div
              class="col col-md-2 col-xs-12 text-center"
              :key="index"
            >
              <q-input
                v-model="model.data_entrada_tarde"
                data-vv-name="data_entrada_tarde"
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
                        v-model="model.data_entrada_tarde"
                        @input="() => $refs.qDateProxy.hide()"
                      />
                    </q-popup-proxy>
                  </q-icon>
                </template>
              </q-input>
            </div>
            <div
              class="col col-md-2 col-xs-12 text-center"
              :key="index"
            >
              <q-input
                v-model="model.data_saida_tarde"
                data-vv-name="data_saida_tarde"
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
                        v-model="model.data_saida_tarde"
                        @input="() => $refs.qDateProxy.hide()"
                      />
                    </q-popup-proxy>
                  </q-icon>
                </template>
              </q-input>
            </div>
          </template>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
import {
  QSelect,
  QInput,
  QIcon,
  QPopupProxy,
  QDate
} from 'quasar'
import _ from 'lodash'
export default {
  name: 'LivroPontoForm',
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
    QSelect,
    QInput,
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
        this.$store.dispatch('usuarios/loadItem', this.id)
      } else {
        this.$store.commit('usuarios/setItem', {})
      }
      this.$store.dispatch('usuario/loadList', {})
      this.$store.dispatch('mes/loadList', {})
      this.$store.dispatch('ano/loadList', {})
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
              usuario: this.model.usuario,
              mes: this.model.mes,
              ano: this.model.ano,
              data_entrada_manha: this.model.data_entrada_manha,
              data_saida_manha: this.model.data_saida_manha,
              data_entrada_tarde: this.model.data_entrada_tarde,
              data_saida_tarde: this.model.data_saida_tarde
            }
            if (this.action === 'edit') {
              this.$store.dispatch('usuarios/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('usuarios/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'usuarios.editar',
                    params: { id: this.$store.state.usuarios.currentId }
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
      return {
        mes: 8,
        ano: 2019
      }
    },
    datas () {
      return [
        '01/08/2019', '02/08/2019', '03/08/2019', '04/08/2019', '05/08/2019',
        '06/08/2019', '07/08/2019', '08/08/2019', '09/08/2019', '10/08/2019'
      ]
    },
    usuario () {
      return _.orderBy(this.$store.state.usuario.list.map(
        data =>
          ({
            label: data.usuario,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    mes () {
      return _.orderBy(this.$store.state.mes.list.map(
        data =>
          ({
            label: data.mes,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    ano () {
      return _.orderBy(this.$store.state.ano.list.map(
        data =>
          ({
            label: data.ano,
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
