<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-md-6 col-xs-12">
            <q-select
              :options="pagamento"
              v-model="model.pagamento"
              label="Selecione a Forma de Pagamento"
              data-vv-name="pagamento"
              v-validate="'required'"
              :error="errors.has('pagamento')"
              :error-message="errors.first('pagamento')"
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
              @click="$router.push({name:'remessas.index'})"
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
  QSelect
} from 'quasar'
import _ from 'lodash'
export default {
  name: 'RemessasForm',
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
    QSelect
  },
  data: () => ({
    submitting: false
  }),
  methods: {
    getData () {
      if (this.id) {
        this.$store.dispatch('remessas/loadItem', this.id)
      } else {
        this.$store.commit('remessas/setItem', {})
      }
      this.$store.dispatch('pagamento/loadList', {})
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
              nome: this.model.pagamento
            }
            if (this.action === 'edit') {
              this.$store.dispatch('remessas/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('remessas/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'remessas.editar',
                    params: { id: this.$store.state.remessas.currentId }
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
      return this.$store.state.remessas.item
    },
    pagamento () {
      return _.orderBy(this.$store.state.pagamento.list.map(
        data =>
          ({
            label: data.pagamento,
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
