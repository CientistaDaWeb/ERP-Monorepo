<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-3 col-xs-12">
            <q-select
              :options="banco"
              v-model="model.banco"
              label="Banco"
              data-vv-name="banco"
              v-validate="'required'"
              :error="errors.has('banco')"
              :error-message="errors.first('banco')"
            />
          </div>
          <div class="col col-sm-7 col-xs-12">
            <q-input
              v-model="model.forma_pagto"
              label="Nome da Forma de Pagamento"
              data-vv-name="forma_pagto"
              v-validate="'required'"
              :error="errors.has('forma_pagto')"
              :error-message="errors.first('forma_pagto')"
            />
          </div>
          <div class="col col-sm-2 col-xs-12">
            <q-select
              :options="remessa"
              v-model="model.remessa"
              label="Gera Remessa?"
              data-vv-name="remessa"
              v-validate="'required'"
              :error="errors.has('remessa')"
              :error-message="errors.first('remessa')"
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
              @click="$router.push({name:'formas-pagamento.index'})"
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
  QSelect
} from 'quasar'
import _ from 'lodash'
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
    QBtn,
    QInput,
    QSelect
  },
  data: () => ({
    submitting: false
  }),
  methods: {
    getData () {
      if (this.id) {
        this.$store.dispatch('formasPagamento/loadItem', this.id)
      } else {
        this.$store.commit('formasPagamento/setItem', {})
      }
      this.$store.dispatch('banco/loadList', {})
      this.$store.dispatch('remessa/loadList', {})
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
              banco: this.model.banco,
              forma_pagto: this.model.forma_pagto,
              remessa: this.model.remessa
            }
            if (this.action === 'edit') {
              this.$store.dispatch('formasPagamento/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('formasPagamento/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'formas-pagamento.editar',
                    params: { id: this.$store.state.formasPagamento.currentId }
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
      return this.$store.state.formasPagamento.item
    },
    banco () {
      return _.orderBy(this.$store.state.banco.list.map(
        data =>
          ({
            label: data.banco,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    remessa () {
      return _.orderBy(this.$store.state.remessa.list.map(
        data =>
          ({
            label: data.remessa,
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
