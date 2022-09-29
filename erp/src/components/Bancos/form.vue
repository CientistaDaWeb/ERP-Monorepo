<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-6 col-xs-12">
            <q-select
              filter
              :options="empresas"
              v-model="model.empresa_id"
              label="Empresa"
              data-vv-name="Empresa"
              v-validate="'required'"
              :error="errors.has('Empresa')"
              :error-message="errors.first('Empresa')"
            />
          </div>
          <div class="col col-sm-6 col-xs-12">
            <q-input
              v-model="model.banco"
              label="Banco"
              data-vv-name="Banco"
              v-validate="'required'"
              :error="errors.has('Banco')"
              :error-message="errors.first('Banco')"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-input
              v-model="model.agencia"
              label="Agência"
              data-vv-name="Agência"
              v-validate="'required'"
              :error="errors.has('Agência')"
              :error-message="errors.first('Agência')"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-input
              v-model="model.conta_corrente"
              label="Conta Corrente"
              data-vv-name="Conta Corrente"
              v-validate="'required'"
              :error="errors.has('Conta Corrente')"
              :error-message="errors.first('Conta Corrent')"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-input
              v-model="model.carteira"
              label="Carteira"
              data-vv-name="Carteira"
              v-validate="'required'"
              :error="errors.has('Carteira')"
              :error-message="errors.first('Carteira')"
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
              @click="$router.push({name:'bancos.index'})"
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
  name: 'BancosForm',
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
        this.$store.dispatch('bancos/loadItem', this.id)
      } else {
        this.$store.commit('bancos/setItem', {})
      }
      this.$store.dispatch('empresas/loadList', {})
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
              empresa_id: this.model.empresa_id,
              banco: this.model.banco,
              agencia: this.model.agencia,
              conta_corrente: this.model.conta_corrente,
              carteira: this.model.carteira
            }
            if (this.action === 'edit') {
              this.$store.dispatch('bancos/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('bancos/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'bancos.editar',
                    params: { id: this.$store.state.bancos.currentId }
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
      return this.$store.state.bancos.item
    },
    empresas () {
      return _.orderBy(this.$store.state.empresas.list.map(
        data =>
          ({
            label: data.razao_social,
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
