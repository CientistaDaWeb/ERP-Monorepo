<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-3 col-xs-12">
            <q-input
              v-model="model.codigo"
              label="Código do IBGE"
              data-vv-name="Código do IBGE"
              v-validate="'required'"
              :error="errors.has('Código do IBGE')"
              :error-message="errors.first('Código do IBGE')"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-select
              filter
              :options="estados"
              v-model="selectEstados"
              label="Estado"
              data-vv-name="Estado"
              v-validate="'required'"
              :error="errors.has('Estado')"
              :error-message="errors.first('Estado')"
            />
          </div>
          <div class="col col-sm-5 col-xs-12">
            <q-input
              v-model="model.nome"
              label="Nome"
              data-vv-name="Nome"
              v-validate="'required'"
              :error="errors.has('Nome')"
              :error-message="errors.first('Nome')"
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
              @click="$router.push({name:'municipios.index'})"
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
  QSelect
} from 'quasar'
// import _ from 'lodash'

export default {
  name: 'MunicipiosForm',
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
    QSelect
  },
  data: () => ({
    submitting: false,
    estados: [],
    selectEstados: {
      label: '',
      value: ''
    }
  }),
  methods: {
    getData () {
      if (this.id) {
        this.$store.dispatch('municipios/loadItem', this.id)
      } else {
        this.$store.commit('municipios/setItem', {})
      }
      // this.$store.dispatch('estados/loadList', {})
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
              estado_id: this.selectEstados.value,
              nome: this.model.nome,
              codigo: this.model.codigo
            }
            if (this.action === 'edit') {
              this.$store.dispatch('municipios/updateItem', { data: data, id: this.id })
                .then(() => {
                  this.$router.push({
                    name: 'municipios.index'
                  })
                })
            } else {
              this.$store.dispatch('municipios/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'municipios.index'
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
      return this.$store.state.municipios.item
    }
    // estados () {
    //   return _.orderBy(this.$store.state.estados.list.map(
    //     data =>
    //       ({
    //         label: data.estado,
    //         value: data.id
    //       })
    //   ), 'label', 'ASC')
    // }
  },
  mounted () {
    this.getData()
    this.$store.dispatch('estados/loadList',
      {
        // limit: 30
        // where: {
        //   cliente_id: this.model.ordem_servico.orcamento.cliente_id
        // }
      }).then((data) => {
      this.estados = data.data.map(data => {
        console.log(data)
        if (parseInt(data.id) === parseInt(this.model.estado_id)) {
          this.selectEstados.value = data.id
          this.selectEstados.label = data.estado
        }
        return {
          label: data.estado,
          value: data.id
        }
      })
    })
  }
}
</script>

<style>
</style>
