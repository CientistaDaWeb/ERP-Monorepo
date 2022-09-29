<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-3 col-xs-12">
            <q-input
              v-model="model.documento"
              label="CNPJ"
              data-vv-name="documento"
              v-validate="'required'"
              :error="errors.has('documento')"
              :error-message="errors.first('documento')"
            />
          </div>
          <div class="col col-sm-9 col-xs-12">
            <q-input
              v-model="model.razao_social"
              label="Razão Social / Nome"
              data-vv-name="razao_social"
              v-validate="'required'"
              :error="errors.has('razao_social')"
              :error-message="errors.first('razao_social')"
            />
          </div>
          <div class="co col-md-6 col-xs-12">
            <q-input
              v-model="model.nome_fantasia"
              label="Nome Fantasia / Apelido"
              data-vv-name="nome_fantasia"
              v-validate="'required'"
              :error="errors.has('nome_fantasia')"
              :error-message="errors.first('nome_fantasia')"
            />
          </div>
          <div class="co col-md-3 col-xs-12">
            <q-input
              v-model="model.inscricao_estadual"
              label="Inscrição Estadual"
              data-vv-name="inscricao_estadual"
              v-validate="'required'"
              :error="errors.has('inscricao_estadual')"
              :error-message="errors.first('inscricao_estadual')"
            />
          </div>
          <div class="co col-md-3 col-xs-12">
            <q-input
              v-model="model.inscricao_municipal"
              label="Inscrição Municipal"
              data-vv-name="inscricao_municipal"
              v-validate="'required'"
              :error="errors.has('inscricao_municipal')"
              :error-message="errors.first('inscricao_municipal')"
            />
          </div>
          <div class="col col-md-5 col-xs-12">
            <q-input
              v-model="model.email"
              label="E-mail"
              data-vv-name="email"
              v-validate="'required'"
              :error="errors.has('email')"
              :error-message="errors.first('email')"
            />
          </div>
          <div class="col col-md-5 col-xs-12">
            <q-input
              v-model="model.website"
              label="Website"
              data-vv-name="website"
              v-validate="'required'"
              :error="errors.has('website')"
              :error-message="errors.first('website')"
            />
          </div>
          <div class="col col-md-2 col-xs-12">
            <q-input
              v-model="model.numero_fepan"
              label="Nº Fepan"
              data-vv-name="numero_fepan"
              v-validate="'required'"
              :error="errors.has('numero_fepan')"
              :error-message="errors.first('numero_fepan')"
            />
          </div>
          <div class="col col-md-3 col-xs-12">
            <q-select
              :options="estados"
              v-model="selectEstados"
              label="Estado"
              data-vv-name="uf"
              v-validate="'required'"
              :error="errors.has('uf')"
              :error-message="errors.first('uf')"
            />
          </div>
          <div class="col col-md-7 col-xs-12">
            <q-select
              :options="municipios"
              v-model="selectMunicipios"
              label="Municipio"
              data-vv-name="municipio"
              v-validate="'required'"
              :error="errors.has('municipio')"
              :error-message="errors.first('municipio')"
            />
          </div>
          <div class="col col-md-2 col-xs-12">
            <q-input
              v-model="model.cep"
              label="CEP"
              data-vv-name="cep"
              v-validate="'required'"
              :error="errors.has('cep')"
              :error-message="errors.first('cep')"
            />
          </div>
          <div class="col col-md-10 col-xs-12">
            <q-input
              v-model="model.endereco"
              label="Endereço"
              data-vv-name="endereco"
              v-validate="'required'"
              :error="errors.has('endereco')"
              :error-message="errors.first('endereco')"
            />
          </div>
          <div class="col col-md-2 col-xs-12">
            <q-input
              v-model="model.numero"
              label="Número"
              data-vv-name="numero"
              v-validate="'required'"
              :error="errors.has('numero')"
              :error-message="errors.first('numero')"
            />
          </div>
          <div class="col col-md-6 col-xs-12">
            <q-input
              v-model="model.complemento"
              label="Complemento"
              data-vv-name="complemento"
              :error="errors.has('complemento')"
              :error-message="errors.first('complemento')"
            />
          </div>
          <div class="col col-md-6 col-xs-12">
            <q-input
              v-model="model.bairro"
              label="Bairro"
              data-vv-name="bairro"
              v-validate="'required'"
              :error="errors.has('bairro')"
              :error-message="errors.first('bairro')"
            />
          </div>
          <div class="col col-md-4 col-xs-12">
            <q-input
              v-model="model.telefone"
              label="Telefone"
              data-vv-name="telefone"
              :error="errors.has('telefone')"
              :error-message="errors.first('telefone')"
            />
          </div>
          <div class="col col-md-4 col-xs-12">
            <q-input
              v-model="model.telefone2"
              label="Telefone 2"
              data-vv-name="telefone2"
              :error="errors.has('telefone2')"
              :error-message="errors.first('telefone2')"
            />
          </div>
          <div class="col col-md-4 col-xs-12">
            <q-input
              v-model="model.telefone3"
              label="Telefone 3"
              data-vv-name="telefone3"
              :error="errors.has('telefone3')"
              :error-message="errors.first('telefone3')"
            />
          </div>
          <div class="col col-md-6 col-xs-12">
            <q-uploader
              v-model="model.logomarca"
              flat
              bordered
              url="http://localhost"
              label="Enviar um logo"
              :error="errors.has('logomarca')"
              :error-message="errors.first('logomarca')"
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
              @click="$router.push({name:'empresas.index'})"
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
  QBtn,
  QInput,
  QSelect,
  QUploader
} from 'quasar'
// import _ from 'lodash'
export default {
  name: 'EmpresasForm',
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
    QBtn,
    QInput,
    QSelect,
    QUploader
  },
  data: () => ({
    submitting: false,
    municipios: [],
    selectMunicipios: {
      label: '',
      value: ''
    },
    estados: [],
    selectEstados: {
      label: '',
      value: ''
    }
  }),
  methods: {
    getData () {
      if (this.id) {
        this.$store.dispatch('empresas/loadItem', this.id)
      } else {
        this.$store.commit('empresas/setItem', {})
      }

      // this.$store.dispatch('uf/loadList', {})
      // this.$store.dispatch('municipio/loadList', {})
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
              documento: this.model.documento,
              razao: this.model.razao_social,
              fantasia: this.model.nome_fantasia,
              inscricao_estadual: this.model.inscricao_estadual,
              inscricao_municipal: this.model.inscricao_municipal,
              email: this.model.email,
              website: this.model.website,
              numero_fepan: this.model.numero_fepan,
              estado_id: this.model.estado_id,
              municipio_id: this.model.municipio_id,
              cep: this.model.cep,
              endereco: this.model.endereco,
              numero: this.model.numero,
              complemento: this.model.complemento,
              bairro: this.model.bairro,
              telefone: this.model.telefone,
              telefone2: this.model.telefone2,
              telefone3: this.model.telefone3,
              logomarca: this.model.logomarca
            }
            if (this.action === 'edit') {
              this.$store.dispatch('empresas/updateItem', { data: data, id: this.id })
            } else {
              console.log(data)
              this.$store.dispatch('empresas/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'empresas.editar',
                    params: { id: this.$store.state.empresas.currentId }
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
      return this.$store.state.empresas.item
    }
    // uf () {
    //   return _.orderBy(this.$store.state.uf.list.map(
    //     data =>
    //       ({
    //         label: data.uf,
    //         value: data.id
    //       })
    //   ), 'label', 'ASC')
    // },
    // municipio () {
    //   return _.orderBy(this.$store.state.municipio.list.map(
    //     data =>
    //       ({
    //         label: data.municipio,
    //         value: data.id
    //       })
    //   ), 'label', 'ASC')
    // }
  },
  mounted () {
    this.getData()
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
      }
      )
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
      }
      )
    })
  }

}
</script>

<style>
</style>
