<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-5 col-xs-12">
            <q-select
              filter
              :options="empresas"
              v-model="selectEmpresas"
              label="Empresa"
              data-vv-name="Empresa"
              v-validate="'required'"
              :error="errors.has('Empresa')"
              :error-message="errors.first('Empresa')"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-select
              :options="tipos"
              v-model="selectTipos"
              label="Tipo"
              data-vv-name="Tipo"
              v-validate="'required'"
              :error="errors.has('Tipo')"
              :error-message="errors.first('Tipo')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              v-model="model.data_geracao"
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
                      v-model="model.data_geracao"
                      @input="() => $refs.qDateProxy.hide()"
                    />
                  </q-popup-proxy>
                </q-icon>
              </template>
            </q-input>
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
              @click="$router.push({name:'notas-fiscais.index'})"
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
  QSelect
} from 'quasar'
// import _ from 'lodash'
import moment from 'moment'

export default {
  name: 'NotasFiscaisForm',
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
    QPopupProxy,
    QSelect
  },
  data: () => ({
    submitting: false,
    empresas: [],
    selectEmpresas: {
      label: '',
      value: ''
    },
    tipos: [],
    selectTipos: {
      label: '',
      value: ''
    }
  }),
  methods: {
    getData () {
      if (this.id) {
        this.$store.dispatch('notasFiscais/loadItem', this.id)
      } else {
        this.$store.commit('notasFiscais/setItem', {})
      }
      // this.$store.dispatch('empresas/loadList', {})
      // this.$store.dispatch('tipos/loadList', {})
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
              empresa_id: this.selectEmpresas.value,
              data_geracao: this.model.data_geracao.split('/').reverse().join('-'),
              // cliente: this.model.cliente,
              numero: this.model.numero,
              valor: this.model.valor,
              valor_retido: this.model.valor_retido,
              tipo: this.selectTipos.value
            }
            if (this.action === 'edit') {
              console.log(data)
              this.$store.dispatch('notasFiscais/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('notasFiscais/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'notasFiscais.editar',
                    params: { id: this.$store.state.notasFiscais.currentId }
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
      let store = this.$store.state.notasFiscais.item
      if (store.data_geracao) {
        store.data_geracao = moment(store.data_geracao).format('DD/MM/YYYY')
      }
      return store
    }
    // empresas () {
    //   return _.orderBy(this.$store.state.empresas.list.map(
    //     data =>
    //       ({
    //         label: data.razao_social,
    //         value: data.id
    //       })
    //   ), 'label', 'ASC')
    // },
    // tipos () {
    //   return _.orderBy(this.$store.state.tipos.list.map(
    //     data =>
    //       ({
    //         label: data.tipo,
    //         value: data.id
    //       })
    //   ), 'label', 'ASC')
    // }
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
    this.tipos = this.$store.state.empresas.tipos.map(data => {
      if (data.value === this.model.tipo) {
        this.selectTipos.value = data.value
        this.selectTipos.label = data.label
      }
      return {
        label: data.label,
        value: data.value
      }
    })
  }
}
</script>

<style>
</style>
