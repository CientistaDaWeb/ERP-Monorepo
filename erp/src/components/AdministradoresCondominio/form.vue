<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-6 col-xs-12">
            <q-input
              v-model="model.nome"
              label="Nome"
              data-vv-name="Nome"
              v-validate="'required'"
              :error="errors.has('Nome')"
              :error-message="errors.first('Nome')"
            />
          </div>
          <div class="col col-sm-6 col-xs-12">
            <q-input
              v-model="model.contato"
              label="Contato"
            />
          </div>
          <div class="col col-sm-6 col-xs-12">
            <q-input
              v-model="model.email"
              label="E-mail"
              data-vv-name="E-mail"
              v-validate="'required|email'"
              :error="errors.has('E-mail')"
              :error-message="errors.first('E-mail')"
            />
          </div>
          <div class="col col-sm-6 col-xs-12">
            <q-input
              v-model="model.endereco"
              label="Endereço"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-input
              v-model="model.telefone"
              label="Telefone"
              v-mask="[&quot;(##) ####.####&quot;, &quot;(##) #####.####&quot;]"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-input
              v-model="model.telefone_2"
              label="Telefone 2"
              v-mask="[&quot;(##) ####.####&quot;, &quot;(##) #####.####&quot;]"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-input
              v-model="model.telefone_3"
              label="Telefone 3"
              v-mask="[&quot;(##) ####.####&quot;, &quot;(##) #####.####&quot;]"
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
  QBtn
} from 'quasar'

export default {
  name: 'AdministradoresCondominioForm',
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
    QBtn
  },
  data: () => ({
    submitting: false
  }),
  methods: {
    getData () {
      if (this.id) {
        this.$store.dispatch('administradoresCondominio/loadItem', this.id)
      } else {
        this.$store.commit('administradoresCondominio/setItem', {})
      }
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
              nome: this.model.nome,
              email: this.model.email,
              contato: this.model.contato,
              endereco: this.model.endereco,
              telefone: this.model.telefone,
              telefone_2: this.model.telefone_2,
              telefone_3: this.model.telefone_3
            }
            if (this.action === 'edit') {
              this.$store.dispatch('administradoresCondominio/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('administradoresCondominio/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'administradores-condominio.editar',
                    params: { id: this.$store.state.administradoresCondominio.currentId }
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
      return this.$store.state.administradoresCondominio.item
    }
  },
  mounted () {
    this.getData()
  }
}
</script>

<style>
</style>
