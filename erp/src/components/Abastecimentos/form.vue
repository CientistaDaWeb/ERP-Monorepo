<template>
  <form @submit.prevent.stop="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-2 col-xs-12">
            <q-select
              :options="caminhoes"
              v-model="selectCaminhoes"
              label="Caminhão"
              data-vv-name="Caminhão"
              v-validate="'required'"
              :error="errors.has('Caminhão')"
              :error-message="errors.first('Caminhão')"
            />
            <!-- <FormSelectWithFilter
              :options-list="caminhoes"
              float-label="Caminhão"
              :model="model.caminhao_id"
            /> -->
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-select
              :options="aditivos"
              v-model="selectAditivos"
              label="Aditivos"
              data-vv-name="Aditivos"
              v-validate="'required'"
              :error="errors.has('Aditivos')"
              :error-message="errors.first('Aditivos')"
            />
            <!-- <FormSelectWithFilter
              :options-list="aditivos"
              float-label="Aditivos"
              :model="model.aditivo_id"
            /> -->
          </div>
          <div class="col col-sm-6 col-xs-12">
            <q-select
              :options="fornecedores"
              v-model="selectFornecedores"
              label="Fornecedores"
              data-vv-name="Fornecedores"
              v-validate="'required'"
              :error="errors.has('Fornecedores')"
              :error-message="errors.first('Fornecedores')"
            />
            <!-- <FormSelectWithFilter
              :options-list="fornecedores"
              float-label="Fornecedores"
              :model="model.fornecedor_id"
            /> -->
          </div>
          <div class="col col-sm-2 col-xs-12">
            <q-input
              v-model="model.data"
              label="Data"
              data-vv-name="data"
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
          <div class="col col-sm-2 col-xs-12">
            <q-input
              v-model="model.litros"
              label="Litros/Unidades"
              data-vv-name="Litros"
              v-validate="'required'"
              :error="errors.has('Litros')"
              :error-message="errors.first('Litros')"
            />
          </div>
          <div class="col col-sm-2 col-xs-12">
            <q-input
              v-model="model.km"
              label="Km"
              data-vv-name="Km"
              v-validate="'required'"
              :error="errors.has('Km')"
              :error-message="errors.first('Km')"
            />
          </div>
          <div class="col col-sm-2 col-xs-12">
            <q-input
              v-model="model.media"
              label="Média"
              data-vv-name="Média"
              v-validate="'required'"
              :error="errors.has('Média')"
              :error-message="errors.first('Média')"
            />
          </div>
          <div class="col col-sm-2 col-xs-12">
            <q-input
              prefix="R$"
              v-model="model.valor_litro"
              label="Valor por Litro"
              data-vv-name="Litro"
              v-validate="'required'"
              :error="errors.has('Litro')"
              :error-message="errors.first('Litro')"
            />
          </div>
          <div class="col col-sm-2 col-xs-12">
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
        </div>
      </div>
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-xs-6">
            <q-btn
              color="negative"
              glossy
              @click="$router.push({name:'abastecimentos.index'})"
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
  QBtn,
  QDate,
  QPopupProxy
} from 'quasar'
// import _ from 'lodash'
import moment from 'moment'
// import FormSelectWithFilter from '../_Form/selectWithFilter'

export default {
  name: 'AbastecimentosForm',
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
    // FormSelectWithFilter,
    QInput,
    QBtn,
    QDate,
    QPopupProxy
  },
  data: () => ({
    submitting: false,
    caminhoes: [],
    selectCaminhoes: {
      label: '',
      value: ''
    },
    aditivos: [],
    selectAditivos: {
      label: '',
      value: ''
    },
    fornecedores: [],
    selectFornecedores: {
      label: '',
      value: ''
    }
  }),
  methods: {
    getData () {
      if (this.id) {
        this.$store.dispatch('abastecimentos/loadItem', this.id)
      } else {
        this.$store.commit('abastecimentos/setItem', {})
      }
      // this.$store.dispatch('caminhoes/loadList', {})
      // this.$store.dispatch('aditivos/loadList', {})
      // this.$store.dispatch('fornecedores/loadList', {})
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
              aditivo_id: this.selectAditivos.value,
              data: date.formatDate(this.model.data, 'YYYY-MM-DD'),
              litros: this.model.litros,
              km: this.model.km,
              valor: this.model.valor,
              media: this.model.media,
              valor_litro: this.model.valor_litro,
              fornecedor_id: this.selectFornecedores.value,
              caminhao_id: this.selectCaminhoes.value
            }
            if (this.action === 'edit') {
              this.$store.dispatch('abastecimentos/updateItem', { data: data, id: this.id })
                .then(() => {
                  this.$router.push({
                    name: 'abastecimentos.index'
                  })
                })
            } else {
              this.$store.dispatch('abastecimentos/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'abastecimentos.index'
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
    // caminhoes () {
    //   return _.orderBy(this.$store.state.caminhoes.list.map(
    //     data =>
    //       ({
    //         label: data.placa,
    //         value: data.id
    //       })
    //   ), 'label', 'ASC')
    // },
    // aditivos () {
    //   return _.orderBy(this.$store.state.aditivos.list.map(
    //     data =>
    //       ({
    //         label: data.nome,
    //         value: data.id
    //       })
    //   ), 'label', 'ASC')
    // },
    // fornecedores () {
    //   return _.orderBy(this.$store.state.fornecedores.list.map(
    //     data =>
    //       ({
    //         label: data.razao_social,
    //         value: data.id
    //       })
    //   ), 'label', 'ASC')
    // }
  },
  mounted () {
    this.getData()
    this.$store.dispatch('fornecedores/loadList',
      {
        limit: 5
        // where: {
        //   cliente_id: this.model.ordem_servico.orcamento.cliente_id
        // }
      }).then((data) => {
      this.fornecedores = data.data.map(data => {
        // console.log(data)
        if (parseInt(data.id) === parseInt(this.model.caminhao_id)) {
          this.selectFornecedores.value = data.id
          this.selectFornecedores.label = data.nome_fantasia
        }
        return {
          label: data.nome_fantasia,
          value: data.id
        }
      })
    })
    this.$store.dispatch('caminhoes/loadList',
      {
        // limit: 30
        // where: {
        //   cliente_id: this.model.ordem_servico.orcamento.cliente_id
        // }
      }).then((data) => {
      this.caminhoes = data.data.map(data => {
        if (parseInt(data.id) === parseInt(this.model.caminhao_id)) {
          this.selectCaminhoes.value = data.id
          this.selectCaminhoes.label = data.nome
        }
        return {
          label: data.nome,
          value: data.id
        }
      })
    })

    this.$store.dispatch('aditivos/loadList',
      {
        // limit: 30
        // where: {
        //   cliente_id: this.model.ordem_servico.orcamento.cliente_id
        // }
      }).then((data) => {
      this.aditivos = data.data.map(data => {
        if (parseInt(data.id) === parseInt(this.model.aditivo_id)) {
          this.selectAditivos.value = data.id
          this.selectAditivos.label = data.nome
        }
        return {
          label: data.nome,
          value: data.id
        }
      })
    })
  }

}
</script>

<style>
</style>
