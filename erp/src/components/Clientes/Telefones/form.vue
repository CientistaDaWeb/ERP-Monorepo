<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-sm-12 col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-3 col-xs-12">
            <q-select
              filter
              v-model="model.categoria_id"
              :options="categorias"
              label="Categoria"
              data-vv-name="Categoria"
              v-validate="'required'"
              :error="errors.has('Categoria')"
              :error-message="errors.first('Categoria')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              v-model="model.contato"
              label="Contato"
            />
          </div>
          <div class="col col-sm-6 col-xs-12">
            <q-input
              v-model="model.telefone"
              v-mask="[&quot;(##) ####.####&quot;, &quot;(##) #####.####&quot;]"
              label="Telefone"
              data-vv-name="Telefone"
              v-validate="'required'"
              :error="errors.has('Telefone')"
              :error-message="errors.first('Telefone')"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-input
              type="email"
              v-model="model.email"
              label="E-mail"
            />
          </div>
          <div class="col col-sm-6 col-xs-12">
            <q-input
              v-model="model.informacao"
              label="Informação Adicional"
            />
          </div>
          <div class="col col-sm-2 col-xs-12">
            <q-select
              filter
              v-model="model.padrao"
              :options="padroes"
              label="Padrão"
              data-vv-name="Padrão"
              v-validate="'required'"
              :error="errors.has('Padrão')"
              :error-message="errors.first('Padrão')"
            />
          </div>
        </div>
      </div>
      <div class="col col-sm-12 col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-xs-6">
            <q-btn
              color="negative"
              glossy
              @click="$router.push({name:'clientes.editar', params: {id: cliente_id, view: 'telefones'}})"
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

export default {
  name: 'ClientesTelefonesForm',
  props: {
    clienteId: {
      type: Number,
      required: true
    },
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
        this.$store.dispatch('clientesTelefones/loadItem', this.id)
      } else {
        this.$store.commit('clientesTelefones/setItem', {})
      }
      this.$store.dispatch('telefonesCategorias/loadList', {})
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
              cliente_id: this.cliente_id,
              categoria_id: this.model.categoria_id,
              telefone: this.model.telefone,
              informacao: this.model.informacao,
              email: this.model.email,
              contato: this.model.contato,
              padrao: this.model.padrao
            }
            if (this.action === 'edit') {
              this.$store.dispatch('clientesTelefones/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('clientesTelefones/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'clientes.editar',
                    params: { id: this.cliente_id, view: 'telefones' }
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
      return this.$store.state.clientesTelefones.item
    },
    categorias () {
      return this.$store.state.telefonesCategorias.list.map(d =>
        ({
          label: d.categoria,
          value: d.id
        })
      )
    },
    padroes () {
      return this.$store.state.clientesTelefones.padroes
    }
  },
  mounted () {
    this.getData()
  }
}
</script>
