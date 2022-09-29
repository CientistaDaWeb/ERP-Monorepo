<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-2 col-xs-12">
            <q-input
              v-model="model.numero_mtr"
              label="Nº do MTR"
              data-vv-name="numero_mtr"
              v-validate="'required'"
              :error="errors.has('numero_mtr')"
              :error-message="errors.first('numero_mtr')"
            />
          </div>
          <div class="col col-sm-10 col-xs-12">
            <q-input
              v-model="model.nome"
              label="Nome do Terceiro"
              data-vv-name="nome"
              :error="errors.has('nome')"
              :error-message="errors.first('nome')"
            />
          </div>
          <div class="col col-sm-2 col-xs-12">
            <q-select
              :options="mtr_gerado"
              v-model="model.mtr_gerado"
              label="MTR Gerado"
              data-vv-name="mtr_gerado"
              v-validate="'required'"
              :error="errors.has('mtr_gerado')"
              :error-message="errors.first('mtr_gerado')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-select
              :options="gerar_certificado"
              v-model="model.gerar_certificado"
              label="MTR precisa gerar certificado"
              data-vv-name="gerar_certificado"
              v-validate="'required'"
              :error="errors.has('gerar_certificado')"
              :error-message="errors.first('gerar_certificado')"
            />
          </div>
          <div class="col col-sm-7 col-xs-12">
            <q-select
              :options="endereco"
              v-model="model.endereco"
              label="Endereço"
              data-vv-name="endereco"
              v-validate="'required'"
              :error="errors.has('endereco')"
              :error-message="errors.first('endereco')"
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
              @click="$router.push({name:'mtrs.index'})"
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

export default {
  name: 'OrdemServicoMtrsForm',
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
        this.$store.dispatch('mtrs/loadItem', this.id)
      } else {
        this.$store.commit('mtrs/setItem', {})
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
              nome: this.model.nome,
              contato: this.model.contato,
              telefone: this.model.telefone,
              telefone_2: this.model.telefone_2,
              telefone_3: this.model.telefone_3
            }
            if (this.action === 'edit') {
              this.$store.dispatch('mtrs/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('mtrs/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'mtrs.editar',
                    params: { id: this.$store.state.mtrs.currentId }
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
      return this.$store.state.mtrs.item
    }
  },
  mounted () {
    console.log('sdasd')
    this.getData()
  }
}
</script>

<style>
</style>
