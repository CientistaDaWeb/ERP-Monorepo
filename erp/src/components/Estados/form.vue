<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-6 col-xs-12">
            <q-input
              v-model="model.estado"
              label="Estado"
              data-vv-name="Estado"
              v-validate="'required'"
              :error="errors.has('Estado')"
              :error-message="errors.first('Estado')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              v-model="model.uf"
              label="UF"
              data-vv-name="UF"
              v-validate="'required'"
              :error="errors.has('UF')"
              :error-message="errors.first('UF')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              v-model="model.codigo"
              label="Código IBGE"
              data-vv-name="Código IBGE"
              v-validate="'required'"
              :error="errors.has('Código IBGE')"
              :error-message="errors.first('Código IBGE')"
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
              @click="$router.push({name:'estados.index'})"
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
  name: 'EstadosForm',
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
        this.$store.dispatch('estados/loadItem', this.id)
      } else {
        this.$store.commit('estados/setItem', {})
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
              estado: this.model.estado,
              uf: this.model.uf,
              codigo: this.model.codigo
            }
            if (this.action === 'edit') {
              this.$store.dispatch('estados/updateItem', { data: data, id: this.id })
                .then(() => {
                  this.$router.push({
                    name: 'estados.index'
                  })
                })
            } else {
              this.$store.dispatch('estados/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'estados.index'
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
      return this.$store.state.estados.item
    }
  },
  mounted () {
    this.getData()
  }
}
</script>

<style>
</style>
