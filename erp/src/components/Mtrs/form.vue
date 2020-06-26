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
import _ from 'lodash'
export default {
  name: 'MtrsForm',
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
      this.$store.dispatch('mtrs/loadList', {})
      this.$store.dispatch('gerar_certificado/loadList', {})
      this.$store.dispatch('endereco/loadList', {})
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
              numero_mtr: this.model.numero_mtr,
              nome: this.model.nome,
              mtr_gerado: this.model.mtr_gerado,
              gerar_certificado: this.model.gerar_certificado,
              endereco: this.model.endereco
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
    },
    mtr_gerado () {
      return _.orderBy(this.$store.state.mtrs.list.map(
        data =>
          ({
            label: data.mtr,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    gerar_certificado () {
      return _.orderBy(this.$store.state.certificados.list.map(
        data =>
          ({
            label: data.certificado,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    endereco () {
      return _.orderBy(this.$store.state.clientesEnderecos.list.map(
        data =>
          ({
            label: data.endereco,
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
