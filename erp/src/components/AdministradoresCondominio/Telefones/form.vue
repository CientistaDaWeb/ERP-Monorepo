<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-md-4 col-xs-12">
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
          <div class="col col-md-4 col-xs-12">
            <q-input
              v-model="model.contato"
              label="Contato"
              data-vv-name="contato"
              v-validate="'required'"
              :error="errors.has('contato')"
              :error-message="errors.first('contato')"
            />
          </div>
          <div class="col col-md-4 col-xs-12">
            <q-input
              v-model="model.telefone"
              label="Telefone"
              data-vv-name="telefone"
              v-validate="'required'"
              :error="errors.has('telefone')"
              :error-message="errors.first('telefone')"
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
              v-model="model.info"
              label="Informação Adicional"
              data-vv-name="info"
              v-validate="'required'"
              :error="errors.has('info')"
              :error-message="errors.first('info')"
            />
          </div>
          <div class="col col-md-2 col-xs-12">
            <q-select
              :options="padrao"
              v-model="model.padrao"
              label="Padrão"
              data-vv-name="padrao"
              v-validate="'required'"
              :error="errors.has('padrao')"
              :error-message="errors.first('padrao')"
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
              @click="$router.push({name:'administradores-condominio.index'})"
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
  QBtn
} from 'quasar'
import _ from 'lodash'
export default {
  name: 'AdministradoresCondominioTelefoneForm',
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
    submitting: false
  }),
  methods: {
    getData () {
      if (this.id) {
        this.$store.dispatch('telefones/loadItem', this.id)
      } else {
        this.$store.commit('telefones/setItem', {})
      }
      this.$store.dispatch('categoria/loadList', {})
      this.$store.dispatch('padrao/loadList', {})
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
              contato: this.model.contato,
              telefone: this.model.telefone,
              email: this.model.email,
              info: this.model.info,
              padrao: this.model.padrao
            }
            if (this.action === 'edit') {
              this.$store.dispatch('telefones/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('telefones/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'telefones.editar',
                    params: { id: this.$store.state.telefones.currentId }
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
      return this.$store.state.telefones.item
    },
    categoria () {
      return _.orderBy(this.$store.state.categoria.list.map(
        data =>
          ({
            label: data.categoria,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    padrao () {
      return _.orderBy(this.$store.state.padrao.list.map(
        data =>
          ({
            label: data.padrao,
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
