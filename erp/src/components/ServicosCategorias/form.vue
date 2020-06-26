<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-12 col-xs-12">
            <q-input
              v-model="model.categoria"
              label="Categoria"
              data-vv-name="Categoria"
              v-validate="'required'"
              :error="errors.has('Categoria')"
              :error-message="errors.first('Categoria')"
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
              @click="$router.push({name:'servicos-categorias.index'})"
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
  name: 'ServicosCategoriasForm',
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
        this.$store.dispatch('servicosCategorias/loadItem', this.id)
      } else {
        this.$store.commit('servicosCategorias/setItem', {})
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
              categoria: this.model.categoria
            }
            if (this.action === 'edit') {
              this.$store.dispatch('servicosCategorias/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('servicosCategorias/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'servicos-categorias.editar',
                    params: { id: this.$store.state.servicosCategorias.currentId }
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
      return this.$store.state.servicosCategorias.item
    }
  },
  mounted () {
    this.getData()
  }
}
</script>

<style>
</style>
