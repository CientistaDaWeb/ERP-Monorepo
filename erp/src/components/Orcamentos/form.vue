<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-6 col-xs-12">
            <q-select

              :options="empresas"
              v-model="selectEmpresas"
              label="Empresa"
              data-vv-name="Empresa"
              v-validate="'required'"
              :error="errors.has('Empresa')"
              :error-message="errors.first('Empresa')"
            />
          </div>
          <div class="col col-sm-6 col-xs-12">
            <q-select
              :options="clientes"
              :loading="loading"
              v-model="selectClientes"
              label="Cliente"
              data-vv-name="Cliente"
              v-validate="'required'"
              :error="errors.has('Cliente')"
              :error-message="errors.first('Cliente')"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-select
              :options="usuarios"
              v-model="selectUsuarios"
              label="Usuario"
              data-vv-name="Usuario"
              v-validate="'required'"
              :error="errors.has('Usuario')"
              :error-message="errors.first('Usuario')"
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
              v-model="data_emissao"
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
                      v-model="data_emissao"
                      @input="() => $refs.qDateProxy.hide()"
                    />
                  </q-popup-proxy>
                </q-icon>
              </template>
            </q-input>
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-select
              :options="vantagens"
              v-model="selectVantagens"
              label="Exibir as Vantagens no Orçamento"
              data-vv-name="Vantagem"
              v-validate="'required'"
              :error="errors.has('Vantagem')"
              :error-message="errors.first('Vantagem')"
            />
          </div>
          <div class="col col-sm-8 col-xs-12">
            <q-select
              :options="status"
              v-model="selectStatus"
              label="Status do Orçamento"
              data-vv-name="Status"
              v-validate="'required'"
              :error="errors.has('Status')"
              :error-message="errors.first('Status')"
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
// import _ from 'lodash'
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
    QSelect,
    QBtn,
    QDate,
    QPopupProxy
  },
  data: () => ({
    data_emissao: '',
    loading: false,
    submitting: false,
    filterCliente: '',
    empresas: [],
    selectEmpresas: {
      label: '',
      value: ''
    },
    status: [],
    selectStatus: {
      label: '',
      value: ''
    },
    clientes: [],
    selectClientes: {
      label: '',
      value: ''
    },
    usuarios: [],
    selectUsuarios: {
      label: '',
      value: ''
    },
    vantagens: [],
    selectVantagens: {
      label: '',
      value: ''
    }
  }),
  methods: {
    getData () {
      // this.$store.dispatch('empresas/loadList', {})
      // this.$store.dispatch('clientes/loadList', {})
      // this.$store.dispatch('usuarios/loadList', {})
      if (this.id) {
        this.$store.dispatch('orcamentos/loadItem', this.id).then(() => {
          // this.setModel()
        })
      } else {
        this.$store.commit('orcamentos/setItem', {
          // empresa_id: '',
          // cliente_id: '',
          // usuario_id: '',
          // valor_total: 0,
          // data_emissao: null,
          // vantagens: 'N',
          // status: 2
        })
      }
    },
    // setModel () {
    //   this.model = this.$store.state.orcamentos.item
    //   this.model.data_emissao = this.model.data_emissao.split('-').reverse().join('/')
    //   if (this.model.valor_total) {
    //     this.model.valor_total = parseFloat(this.model.valor_total).toFixed(2)
    //   }
    // },
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
              empresa_id: this.selectEmpresas.value,
              cliente_id: this.selectClientes.value,
              usuario_id: this.selectUsuarios.value,
              valor_total: this.model.valor_total,
              data_emissao: this.data_emissao.split('/').reverse().join('-'),
              vantagens: this.selectVantagens.value,
              status: this.selectStatus.value
            }
            if (this.action === 'edit') {
              this.$store.dispatch('orcamentos/updateItem', {
                data: data,
                id: this.id
              }).finally(() => {
                this.$validator.reset()
                this.submitting = false
              })
            } else {
              this.$store.dispatch('orcamentos/saveItem', data).then(() => {
                this.$router.push({
                  name: 'orcamentos.editar',
                  params: { id: this.$store.state.orcamentos.currentId }
                }).finally(() => {
                  this.$validator.reset()
                  this.submitting = false
                })
              })
            }
          }
        })
    }

  },
  computed: {
    model () {
      let store = this.$store.state.orcamentos.item
      return store
    }

    // clientes () {
    //   return _.orderBy(
    //     this.$store.state.clientes.list.map(data => ({
    //       label: data.razao_social,
    //       value: data.id
    //     })),
    //     'label',
    //     'ASC'
    //   )
    // },
    // usuarios () {
    //   return _.orderBy(
    //     this.$store.state.usuarios.list.map(data => ({
    //       label: data.nome,
    //       value: data.id
    //     })),
    //     'label',
    //     'ASC'
    //   )
    // },
    // vantagens () {
    //   return _.orderBy(
    //     this.$store.state.orcamentos.vantagensOptions,
    //     'label',
    //     'ASC'
    //   )
    // },
  //   status () {
  //     return _.orderBy(
  //       this.$store.state.orcamentos.statusOptions,
  //       'label',
  //       'ASC'
  //     )
  //   }
  },
  mounted () {
    this.getData()
    this.$store.dispatch('empresas/loadList',
      {}).then((data) => {
      this.empresas = data.data.map(data => {
        if (parseInt(data.id) === parseInt(this.model.empresa_id)) {
          this.selectEmpresas.value = data.id
          this.selectEmpresas.label = data.nome_fantasia
        }
        return {
          label: data.nome_fantasia,
          value: data.id
        }
      })
    })

    this.$store.dispatch('clientes/loadList',

      {
        limit: 30
      }).then((data) => {
      this.clientes = data.data.map(data => {
        if (parseInt(data.id) === parseInt(this.model.cliente_id)) {
          this.selectClientes.value = data.id
          this.selectClientes.label = data.nome_fantasia
        }
        return {
          label: data.nome_fantasia,
          value: data.id
        }
      })
    })
    this.$store.dispatch('usuarios/loadList',
      {}).then((data) => {
      this.usuarios = data.data.map(data => {
        if (parseInt(data.id) === parseInt(this.model.usuario_id)) {
          this.selectUsuarios.value = data.id
          this.selectUsuarios.label = data.nome
        }
        return {
          label: data.nome,
          value: data.id
        }
      })
    })
    this.vantagens = this.$store.state.orcamentos.vantagensOptions.map(data => {
      if (data.value === this.model.vantagens) {
        this.selectVantagens.value = data.value
        this.selectVantagens.label = data.label
      }
      return {
        label: data.label,
        value: data.value
      }
    })
    this.status = this.$store.state.orcamentos.statusOptions.map(data => {
      if (data.value === this.model.status) {
        this.selectStatus.value = data.value
        this.selectStatus.label = data.label
      }
      return {
        label: data.label,
        value: data.value
      }
    })

    this.data_emissao = moment(this.model.data_emissao).format('DD/MM/YYYY')
  }
}
</script>

<style>
</style>
