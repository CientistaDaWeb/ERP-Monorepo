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
          <div class="col col-sm-9 col-xs-12">
            <q-input
              v-model="model.descricao"
              label="Descrição"
              data-vv-name="Descrição"
              v-validate="'required'"
              :error="errors.has('Descrição')"
              :error-message="errors.first('Descrição')"
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
              @click="$router.push({name:'cfops.index'})"
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
  name: 'CfopsForm',
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
        this.$store.dispatch('cfops/loadItem', this.id)
      } else {
        this.$store.commit('cfops/setItem', {})
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
              codigo: this.model.codigo,
              descricao: this.model.descricao
            }
            if (this.action === 'edit') {
              this.$store.dispatch('cfops/updateItem', { data: data, id: this.id })
                .then(() => {
                  this.$router.push({
                    name: 'cfops.index'
                  })
                })
            } else {
              this.$store.dispatch('cfops/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'cfops.index'
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
      return this.$store.state.cfops.item
    }
  },
  mounted () {
    this.getData()
  }
}
</script>

<style>
</style>
