<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-6 col-xs-12">
            <q-select
              ref="empresa_id"
              v-model="model.empresa_id"
              :options="empresas"
              label="Empresa"
              emit-value map-options
              :rules="[val => !!val || 'Epresa Requerida']"
            />
          </div>
          <div class="col col-sm-6 col-xs-12">
            <q-select
              ref="cliente_id"
              v-model="model.cliente_id"
              :options="clientes"
              label="Cliente"
              emit-value map-options
              :rules="[val => !!val || 'Cliente Requerido']"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-select
              ref="usuario_id"
              v-model="model.usuario_id"
              :options="usuarios"
              label="Usuário"
              emit-value map-options
              :rules="[val => !!val || 'Usuário Requerido']"
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
              ref="data_emissao"
              v-model="model.data_emissao"
              label="Data de Emissão"
              data-vv-name="Data de Emissão"
              :error="errors.has('Data de Emissão')"
              :error-message="errors.first('Data de Emissão')"
              :rules="[val => !!val || 'Data Emissao Requerida']"
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
              v-model="model.vantagens"
              :options="vantagens"
              label="Exibir as Vantagens no Orçamento"
              emit-value
              map-options
            />
          </div>
          <div class="col col-sm-8 col-xs-12">
            <q-select
              v-model="model.status"
              :options="status"
              label="Status do Orçamento"
              emit-value
              map-options
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
import {
  QInput,
  QSelect,
  QBtn,
  QDate,
  QPopupProxy
} from 'quasar'
import _ from 'lodash'

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
    QSelect,
    QBtn,
    QDate,
    QPopupProxy
  },
  data: () => ({
    submitting: false,
    filterCliente: '',
    model: {
      empresa_id: '',
      cliente_id: '',
      usuario_id: '',
      valor_total: 0,
      data_emissao: null,
      vantagens: 'N',
      status: 2
    }
  }),
  methods: {
    getData () {
      this.$store.dispatch('empresas/loadList', {})
      this.$store.dispatch('clientes/loadList', {})
      this.$store.dispatch('usuarios/loadList', {})
      if (this.id) {
        this.$store.dispatch('orcamentos/loadItem', this.id).then(() => {
          this.setModel()
        })
      } else {
        this.$store.commit('orcamentos/setItem', {
          empresa_id: '',
          cliente_id: '',
          usuario_id: '',
          valor_total: 0,
          data_emissao: null,
          vantagens: 'N',
          status: 2
        })
      }
    },
    setModel () {
      this.model = this.$store.state.orcamentos.item
      this.model.data_emissao = this.model.data_emissao.split('-').reverse().join('/')
      if (this.model.valor_total) {
        this.model.valor_total = parseFloat(this.model.valor_total).toFixed(2)
      }
    },
    save () {
      this.$refs.empresa_id.validate()
      this.$refs.cliente_id.validate()
      this.$refs.usuario_id.validate()
      this.$refs.data_emissao.validate()
      if (
        this.$refs.empresa_id.hasError ||
        this.$refs.cliente_id.hasError ||
        this.$refs.usuario_id.hasError ||
        this.$refs.data_emissao.hasError
      ) {
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
          data_emissao: this.model.data_emissao.split('/').reverse().join('-'),
          vantagens: this.model.vantagens,
          status: this.model.status
        }
        if (this.action === 'edit') {
          this.$store.dispatch('orcamentos/updateItem', {
            data: data,
            id: this.id
          }).finally(() => {
            this.submitting = false
          })
        } else {
          this.$store.dispatch('orcamentos/saveItem', data).then(() => {
            this.$router.push({
              name: 'orcamentos.editar',
              params: { id: this.$store.state.orcamentos.currentId }
            }).finally(() => {
              this.submitting = false
            })
          })
        }
      }
    }
  },
  computed: {
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
      return _.orderBy(
        this.$store.state.orcamentos.vantagensOptions,
        'label',
        'ASC'
      )
    },
    status () {
      return _.orderBy(
        this.$store.state.orcamentos.statusOptions,
        'label',
        'ASC'
      )
    }
  },
  mounted () {
    this.getData()
  }
}
</script>

<style>
</style>
