<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-12 col-xs-12">
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
              @click="$router.push({name:'aditivos.index'})"
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
  name: 'AditivosForm',
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
        this.$store.dispatch('aditivos/loadItem', this.id)
      } else {
        this.$store.commit('aditivos/setItem', {})
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
              nome: this.model.nome
            }
            if (this.action === 'edit') {
              this.$store.dispatch('aditivos/updateItem', { data: data, id: this.id })
                .then(() => {
                  this.$router.push({
                    name: 'aditivos.index'
                  })
                })
            } else {
              this.$store.dispatch('aditivos/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'aditivos.index'
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
      return this.$store.state.aditivos.item
    }
  },
  mounted () {
    this.getData()
  }
}
</script>

<style>
</style>
