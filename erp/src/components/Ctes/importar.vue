<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-md-3 col-xs-12">
            <q-input
              v-model="model.id"
              label="CTe ID"
              data-vv-name="id"
              v-validate="'required'"
              :error="errors.has('id')"
              :error-message="errors.first('id')"
            />
          </div>
          <div class="col col-md-9 col-xs-12">
            <q-select
              :options="cliente"
              v-model="model.cliente"
              label="Cliente"
              data-vv-name="cliente"
              v-validate="'required'"
              :error="errors.has('cliente')"
              :error-message="errors.first('cliente')"
            />
          </div>
          <div class="col col-md-5 col-xs-12">
            <q-uploader
              v-model="model.xml"
              hide-upload-btn="true"
              flat
              bordered
              url="http://localhost"
              label="XML"
              :error="errors.has('xml')"
              :error-message="errors.first('xml')"
            />
          </div>
          <div class="col col-md-5 col-xs-12">
            <q-uploader
              v-model="model.xml"
              hide-upload-btn="true"
              flat
              bordered
              url="http://localhost"
              label="PDF"
              :error="errors.has('xml')"
              :error-message="errors.first('xml')"
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
              @click="$router.push({name:'usuarios.index'})"
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
  QSelect,
  QUploader
} from 'quasar'

export default {
  name: 'ImportarForm',
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
    QSelect,
    QUploader
  },
  data: () => ({
    submitting: false
  }),
  methods: {
    getData () {
      if (this.id) {
        this.$store.dispatch('ctes/loadItem', this.id)
      } else {
        this.$store.commit('ctes/setItem', {})
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
              this.$store.dispatch('ctes/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('ctes/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'usuarios.editar',
                    params: { id: this.$store.state.ctes.currentId }
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
      return this.$store.state.ctes.item
    }
  },
  mounted () {
    this.getData()
  }
}
</script>

<style>
</style>
