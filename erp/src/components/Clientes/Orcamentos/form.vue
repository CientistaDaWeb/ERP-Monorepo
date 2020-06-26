<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-6 col-xs-12">
            <q-select
              emit-value
              map-options
              use-input
              hide-selected
              fill-input
              input-debounce="0"
              clearable
              @filter="filtroEmpresa"
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
              emit-value
              map-options
              use-input
              hide-selected
              fill-input
              input-debounce="0"
              clearable
              @filter="filtroCliente"
              :options="clientes"
              v-model="model.cliente_id"
              label="Cliente"
              data-vv-name="Cliente"
              v-validate="'required'"
              :error="errors.has('Cliente')"
              :error-message="errors.first('Cliente')"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-select
              emit-value
              map-options
              use-input
              hide-selected
              fill-input
              input-debounce="0"
              clearable
              @filter="filtroUsuario"
              :options="usuarios"
              v-model="model.usuario_id"
              label="Funcionário"
              data-vv-name="Funcionário"
              v-validate="'required'"
              :error="errors.has('Funcionário')"
              :error-message="errors.first('Funcionário')"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-input
              mask="#.##"
              fill-mask="0"
              reverse-fill-mask
              prefix="R$"
              v-model="model.valor_total"
              label="Valor Total"
              helper="caso tenha negociado um valor fechado"
            />
          </div>
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
          <div class="col col-sm-4 col-xs-12">
            <q-select
              emit-value
              map-options
              :options="vantagens"
              v-model="model.vantagens"
              label="Exibir as Vantagens no Orçamento"
              data-vv-name="Exibir as Vantagens no Orçamento"
              v-validate="'required'"
              :error="errors.has('Exibir as Vantagens no Orçamento')"
              :error-message="errors.first('Exibir as Vantagens no Orçamento')"
            />
          </div>
          <div class="col col-sm-8 col-xs-12">
            <q-select
              emit-value
              map-options
              :options="status"
              v-model="model.status"
              label="Status do Orçamento"
              data-vv-name="Status do Orçamento"
              v-validate="'required'"
              :error="errors.has('Status do Orçamento')"
              :error-message="errors.first('Status do Orçamento')"
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
              @click="$router.push({name:'orcamentos.index'})"
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
import { date, QInput, QBtn, QSelect, QDate, QPopupProxy } from 'quasar'
import _ from 'lodash'
import moment from 'moment'

export default {
  name: 'OrcamentosForm',
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
    submitting: false,
    filterCliente: ''
  }),
  methods: {
    getData () {
      if (this.id) {
        this.$store.dispatch('orcamentos/loadItem', this.id)
      } else {
        this.$store.commit('orcamentos/setItem', {})
      }
      this.$store.dispatch('empresas/loadList', {})
      this.$store.dispatch('clientes/loadList', {})
      this.$store.dispatch('usuarios/loadList', {})
    },
    filtroEmpresa (val, update, abort) {
      update(() => {
        const needle = val.toLowerCase()
        this.$store.dispatch('empresas/loadList', {
          filter: needle,
          limit: 10000
        })
      })
    },
    filtroCliente (val, update) {
      this.filtroCliente = val.toLowerCase()
    },
    filtroUsuario (val, update, abort) {
      update(() => {
        const needle = val.toLowerCase()
        this.$store.dispatch('usuarios/loadList', {
          filter: needle,
          limit: 10000
        })
      })
    },
    save () {
      this.$validator.validate().then(result => {
        if (!result) {
          this.$q.notify({
            message:
              'O registro não foi salvo, verifique os campos incorretos.',
            icon: 'fa fa-exclamation-triangle'
          })
        } else {
          this.submitting = true

          let data = {
            empresa_id: this.model.empresa_id,
            cliente_id: this.model.cliente_id,
            usuario_id: this.model.usuario_id,
            valor_total: this.model.valor_total,
            data_emissao: date.formatDate(
              this.model.data_emissao,
              'YYYY-MM-DD'
            ),
            vantagens: this.model.vantagens,
            status: this.model.status
          }
          if (this.action === 'edit') {
            this.$store.dispatch('orcamentos/updateItem', {
              data: data,
              id: this.id
            })
          } else {
            this.$store.dispatch('orcamentos/saveItem', data).then(() => {
              this.$router.push({
                name: 'orcamentos.editar',
                params: { id: this.$store.state.orcamentos.currentId }
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
      let store = this.$store.state.orcamentos.item
      if (store.data_emissao) {
        store.data_emissao = date.formatDate(
          moment(store.data_emissao),
          'DD/MM/YYYY'
        )
      }
      return store
    },
    empresas () {
      return _.orderBy(
        this.$store.state.empresas.list.map(data => ({
          label: data.razao_social,
          value: data.id
        })),
        'label',
        'ASC'
      ).filter(data => {
        return data.label.indexOf(this.filterCliente) > -1
      })
    },
    clientes () {
      return _.orderBy(
        this.$store.state.clientes.list.map(data => ({
          label: data.razao_social,
          value: data.id
        })),
        'label',
        'ASC'
      )
    },
    usuarios () {
      return _.orderBy(
        this.$store.state.usuarios.list.map(data => ({
          label: data.nome,
          value: data.id
        })),
        'label',
        'ASC'
      )
    },
    vantagens () {
      return this.$store.state.orcamentos.vantagensOptions
    },
    status () {
      return this.$store.state.orcamentos.statusOptions
    }
  },
  mounted () {
    this.getData()
  }
}
</script>

<style>
</style>
