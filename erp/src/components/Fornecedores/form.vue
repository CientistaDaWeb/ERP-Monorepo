<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-md-3 col-xs-12">
            <q-select
              :options="categoria"
              v-model="model.categoria"
              label="Categoria"
              data-vv-name="categoria"
              v-validate="'required'"
              :error="errors.has('categoria')"
              :error-message="errors.first('categoria')"
            />
          </div>
          <div class="col col-md-9 col-xs-12" />
          <div class="col col-md-3 col-xs-12">
            <q-input
              v-model="model.cnpj"
              label="CNPJ"
              data-vv-name="CNPJ"
              v-validate="'required'"
              :error="errors.has('cnpj')"
              :error-message="errors.first('cnpj')"
            />
          </div>
          <div class="col col-md-9 col-xs-12">
            <q-input
              v-model="model.razao"
              label="Razão Social / Nome"
              data-vv-name="razao"
              v-validate="'required'"
              :error="errors.has('razao')"
              :error-message="errors.first('razao')"
            />
          </div>
          <div class="co col-md-6 col-xs-12">
            <q-input
              v-model="model.fantasia"
              label="Nome Fantasia / Apelido"
              data-vv-name="fantasia"
              v-validate="'required'"
              :error="errors.has('fantasia')"
              :error-message="errors.first('fantasia')"
            />
          </div>
          <div class="co col-md-3 col-xs-12">
            <q-input
              v-model="model.ie"
              label="Inscrição Estadual"
              data-vv-name="ie"
              v-validate="'required'"
              :error="errors.has('ie')"
              :error-message="errors.first('ie')"
            />
          </div>
          <div class="co col-md-3 col-xs-12">
            <q-input
              v-model="model.im"
              label="Inscrição Municipal"
              data-vv-name="im"
              v-validate="'required'"
              :error="errors.has('im')"
              :error-message="errors.first('im')"
            />
          </div>
          <div class="col col-md-9 col-xs-12">
            <q-input
              v-model="model.email"
              label="E-mail"
              data-vv-name="email"
              v-validate="'required'"
              :error="errors.has('email')"
              :error-message="errors.first('email')"
            />
          </div>
          <div class="col col-md-3 col-xs-12">
            <q-input
              v-model="model.fepan"
              label="Nº Fepan"
              data-vv-name="fepan"
              v-validate="'required'"
              :error="errors.has('fepan')"
              :error-message="errors.first('fepan')"
            />
          </div>
          <div class="col col-md-3 col-xs-12">
            <q-select
              :options="uf"
              v-model="model.uf"
              label="Estado"
              data-vv-name="uf"
              v-validate="'required'"
              :error="errors.has('uf')"
              :error-message="errors.first('uf')"
            />
          </div>
          <div class="col col-md-7 col-xs-12">
            <q-select
              :options="municipio"
              v-model="model.municipio"
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
          <div class="col col-md-4 col-xs-12">
            <q-input
              v-model="model.banco"
              label="Banco"
              data-vv-name="banco"
              :error="errors.has('banco')"
              :error-message="errors.first('banco')"
            />
          </div>
          <div class="col col-md-4 col-xs-12">
            <q-input
              v-model="model.agencia"
              label="Agência"
              data-vv-name="agencia"
              :error="errors.has('agencia')"
              :error-message="errors.first('agencia')"
            />
          </div>
          <div class="col col-md-4 col-xs-12">
            <q-input
              v-model="model.conta"
              label="Conta Corrente"
              data-vv-name="conta"
              :error="errors.has('conta')"
              :error-message="errors.first('conta')"
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
              @click="$router.push({name:'fornecedores.index'})"
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
  QSelect
} from 'quasar'
import _ from 'lodash'
export default {
  name: 'FornecedoresForm',
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
    QSelect
  },
  data: () => ({
    submitting: false
  }),
  methods: {
    getData () {
      if (this.id) {
        this.$store.dispatch('fornecedores/loadItem', this.id)
      } else {
        this.$store.commit('fornecedores/setItem', {})
      }
      this.$store.dispatch('categoria/loadList', {})
      this.$store.dispatch('uf/loadList', {})
      this.$store.dispatch('municipio/loadList', {})
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
              categoria: this.model.categoria,
              cnpj: this.model.cnpj,
              razao: this.model.razao,
              fantasia: this.model.fantasia,
              ie: this.model.ie,
              im: this.model.im,
              email: this.model.email,
              fepan: this.model.fepan,
              uf: this.model.uf,
              municipio: this.model.municipio,
              cep: this.model.cep,
              endereco: this.model.endereco,
              numero: this.model.numero,
              complemento: this.model.complemento,
              bairro: this.model.bairro,
              telefone: this.model.telefone,
              telefone2: this.model.telefone2,
              telefone3: this.model.telefone3,
              banco: this.model.banco,
              agencia: this.model.agencia,
              conta: this.model.conta
            }
            if (this.action === 'edit') {
              this.$store.dispatch('fornecedores/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('fornecedores/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'fornecedores.editar',
                    params: { id: this.$store.state.fornecedores.currentId }
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
      return this.$store.state.fornecedores.item
    },
    categoria () {
      return _.orderBy(this.$store.state.fornecedores.list.map(
        data =>
          ({
            label: data.fornecedores,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    uf () {
      return _.orderBy(this.$store.state.uf.list.map(
        data =>
          ({
            label: data.uf,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    municipio () {
      return _.orderBy(this.$store.state.municipio.list.map(
        data =>
          ({
            label: data.municipio,
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
