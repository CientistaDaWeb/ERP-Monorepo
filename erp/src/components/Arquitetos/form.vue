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
              @click="$router.push({name:'arquitetos.index'})"
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
  name: 'ArquitetosForm',
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
        this.$store.dispatch('arquitetos/loadItem', this.id)
      } else {
        this.$store.commit('arquitetos/setItem', {})
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
              contato: this.model.contato,
              telefone: this.model.telefone,
              telefone_2: this.model.telefone_2,
              telefone_3: this.model.telefone_3
            }
            if (this.action === 'edit') {
              this.$store.dispatch('arquitetos/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('arquitetos/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'arquitetos.editar',
                    params: { id: this.$store.state.arquitetos.currentId }
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
      return this.$store.state.arquitetos.item
    }
  },
  mounted () {
    this.getData()
  }
}
</script>

<style>
</style>
