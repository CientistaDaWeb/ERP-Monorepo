<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-sm-12 col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-3 col-xs-12">
            <q-select
              filter
              v-model="selectCategorias"
              :options="categorias"
              label="Categoria"
              data-vv-name="Categoria"
              v-validate="'required'"
              :error="errors.has('Categoria')"
              :error-message="errors.first('Categoria')"
            />
          </div>
          <div class="col col-sm-2 col-xs-12">
            <q-input
              v-model="model.cep"
              label="CEP"
              v-mask="'#####-###'"
              data-vv-name="CEP"
              v-validate="'required|min:9'"
              :error="errors.has('CEP')"
              :error-message="errors.first('CEP')"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-input
              v-model="model.endereco"
              label="Endereço"
              data-vv-name="Endereço"
              v-validate="'required|min:5'"
              :error="errors.has('Endereço')"
              :error-message="errors.first('Endereço')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              v-model="model.numero"
              label="Número"
              type="number"
              data-vv-name="Número"
              v-validate="'required|min:1'"
              :error="errors.has('Número')"
              :error-message="errors.first('Número')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              v-model="model.complemento"
              label="Complemento"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-input
              v-model="model.bairro"
              label="Bairro"
              data-vv-name="Bairro"
              v-validate="'required'"
              :error="errors.has('Bairro')"
              :error-message="errors.first('Bairro')"
            />
          </div>
          <div class="col col-sm-5 col-xs-12">
            <q-select
              filter
              v-model="selectMunicipios"
              :options="municipios"
              label="Município"
              data-vv-name="Município"
              v-validate="'required'"
              :error="errors.has('Município')"
              :error-message="errors.first('Município')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-select
              filter
              v-model="selectEstados"
              label="Estado"
              :options="estados"
              data-vv-name="Estado"
              v-validate="'required'"
              :error="errors.has('Estado')"
              :error-message="errors.first('Estado')"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-input
              v-model="model.coordenadas"
              label="Coordenadas"
            />
          </div>
          <div class="col col-sm-5 col-xs-12">
            imagem
          </div>
        </div>
      </div>
      <div class="col col-sm-12 col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-xs-6">
            <q-btn
              color="negative"
              glossy
              @click="$router.push({name:'clientes.editar', params: {id: cliente_id, view: 'enderecos'}})"
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

export default {
  name: 'ClientesEnderecosForm',
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
    categorias: [],
    selectCategorias: {
      label: '',
      value: ''
    },
    estados: [],
    selectEstados: {
      label: '',
      value: ''
    },
    municipios: [],
    selectMunicipios: {
      label: '',
      value: ''
    }
  }),
  methods: {
    getData () {
      if (this.id) {
        this.$store.dispatch('clientesEnderecos/loadItem', this.id)
      } else {
        this.$store.commit('clientesEnderecos/setItem', {})
      }
      // this.$store.dispatch('enderecosCategorias/loadList', {})
      // this.$store.dispatch('estados/loadList', {})
      // this.$store.dispatch('municipios/loadList', {})
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
              cliente_id: this.$route.params.cliente_id,
              categoria_id: this.selectCategorias.value,
              estado_id: this.selectEstados.value,
              municipio_id: this.selectMunicipios.value,
              cep: this.model.cep,
              endereco: this.model.endereco,
              numero: this.model.numero,
              complemento: this.model.complemento,
              bairro: this.model.bairro,
              coordenadas: this.model.coordenadas,
              imagem: this.model.imagem
            }
            if (this.action === 'edit') {
              this.$store.dispatch('clientesEnderecos/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('clientesEnderecos/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'clientes.editar',
                    params: { id: this.cliente_id, view: 'enderecos' }
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
      return this.$store.state.clientesEnderecos.item
    }
    // ufs () {
    //   return this.$store.state.estados.list.map(d =>
    //     ({
    //       label: d.estado + ' (' + d.uf + ')',
    //       value: d.id
    //     })
    //   )
    // },
    // municipios () {
    //   return this.$store.state.municipios.list.map(d =>
    //     ({
    //       label: d.nome,
    //       value: d.id
    //     })
    //   )
    // },
    // categorias () {
    //   return this.$store.state.enderecosCategorias.list.map(d =>
    //     ({
    //       label: d.categoria,
    //       value: d.id
    //     })
    //   )
    // }
  },
  mounted () {
    this.getData()
    //  console.log(this.$route.params)
    this.$store.dispatch('enderecosCategorias/loadList',
      {}).then((data) => {
      this.categorias = data.data.map(data => {
        if (parseInt(data.id) === parseInt(this.model.categoria_id)) {
          this.selectCategorias.value = data.id
          this.selectCategorias.label = data.categoria
        }
        return {
          label: data.categoria,
          value: data.id
        }
      })
    })

    this.$store.dispatch('estados/loadList',
      {}).then((data) => {
      this.estados = data.data.map(data => {
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

    this.$store.dispatch('municipios/loadList',
      {}).then((data) => {
      this.municipios = data.data.map(data => {
        if (parseInt(data.id) === parseInt(this.model.municipio_id)) {
          this.selectMunicipios.value = data.id
          this.selectMunicipios.label = data.nome
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
