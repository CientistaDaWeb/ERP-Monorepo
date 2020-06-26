<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-4 col-xs-12">
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
          <div class="col col-sm-4 col-xs-12">
            <q-input
              v-model="model.titulo"
              label="Título"
              data-vv-name="Título"
              v-validate="'required'"
              :error="errors.has('Título')"
              :error-message="errors.first('Título')"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-input
              v-model="model.controller"
              label="Controlador"
              data-vv-name="Controlador"
              v-validate="'required'"
              :error="errors.has('Controlador')"
              :error-message="errors.first('Controlador')"
            />
          </div>
          <div class="col col-sm-2 col-xs-12">
            <q-input
              type="number"
              v-model="model.ordem"
              label="Ordem"
              data-vv-name="Ordem"
              v-validate="'required'"
              :error="errors.has('Ordem')"
              :error-message="errors.first('Ordem')"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-input
              v-model="model.icon"
              label="Ícone"
              data-vv-name="Ícone"
              v-validate="'required'"
              :error="errors.has('Ícone')"
              :error-message="errors.first('Ícone')"
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
              @click="$router.push({name:'modulos.index'})"
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
  name: 'ModulosForm',
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
        this.$store.dispatch('modulos/loadItem', this.id)
      } else {
        this.$store.commit('modulos/setItem', {})
      }
      this.$store.dispatch('modulosCategorias/loadList', {})
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
              controller: this.model.controller,
              ordem: this.model.ordem,
              icon: this.model.icon
            }
            if (this.action === 'edit') {
              this.$store.dispatch('modulos/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('modulos/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'modulos.editar',
                    params: { id: this.$store.state.modulos.currentId }
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
      return this.$store.state.modulos.item
    },
    categorias () {
      return _.orderBy(this.$store.state.modulosCategorias.list.map(
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
