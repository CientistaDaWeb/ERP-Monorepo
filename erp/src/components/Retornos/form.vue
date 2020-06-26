<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-md-12 col-xs-12">
            <q-uploader
              v-model="model.arquivo"
              hide-upload-btn="true"
              flat
              bordered
              url="http://localhost"
              label="Selecione Arquivo"
              :error="errors.has('arquivo')"
              :error-message="errors.first('arquivo')"
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
              @click="$router.push({name:'retornos.index'})"
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
  QUploader
} from 'quasar'

export default {
  name: 'RetornosForm',
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
    QUploader
  },
  data: () => ({
    submitting: false
  }),
  methods: {
    getData () {
      if (this.id) {
        this.$store.dispatch('retornos/loadItem', this.id)
      } else {
        this.$store.commit('retornos/setItem', {})
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
              nome: this.model.arquivo
            }
            if (this.action === 'edit') {
              this.$store.dispatch('retornos/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('retornos/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'retornos.editar',
                    params: { id: this.$store.state.retornos.currentId }
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
      return this.$store.state.retornos.item
    }
  },
  mounted () {
    this.getData()
  }
}
</script>

<style>
</style>
