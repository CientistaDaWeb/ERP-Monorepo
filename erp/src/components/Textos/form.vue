<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-6 col-xs-12">
            <q-select
              filter
              :options="categorias"
              v-model="model.categoria_id"
              label="Categoria"
              data-vv-name="Categoria"
              v-validate="'required'"
              :error="errors.has('Categoria')"
              :error-message="errors.first('Categoria')"
            />
          </div>
          <div class="col col-sm-6 col-xs-12">
            <q-input
              v-model="model.titulo"
              label="Título"
              data-vv-name="Título"
              v-validate="'required'"
              :error="errors.has('Título')"
              :error-message="errors.first('Titulo')"
            />
          </div>
          <div class="col col-sm-12 col-xs-12">
            <q-input
              type="textarea"
              rows="5"
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
              @click="$router.push({name:'textos.index'})"
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
import _ from 'lodash'

export default {
  name: 'TextosForm',
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
        this.$store.dispatch('textos/loadItem', this.id)
      } else {
        this.$store.commit('textos/setItem', {})
      }
      this.$store.dispatch('textosCategorias/loadList', {})
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
              categoria_id: this.model.categoria_id,
              titulo: this.model.titulo,
              descricao: this.model.descricao
            }
            if (this.action === 'edit') {
              this.$store.dispatch('textos/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('textos/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'textos.editar',
                    params: { id: this.$store.state.textos.currentId }
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
      return this.$store.state.textos.item
    },
    categorias () {
      return _.orderBy(this.$store.state.textosCategorias.list.map(
        data =>
          ({
            label: data.categoria,
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
