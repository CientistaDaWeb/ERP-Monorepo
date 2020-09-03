<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-2 col-xs-12">
            <q-input
              v-model="model.mtr"
              label="Nº do MTR"
              data-vv-name="numero_mtr"
              v-validate="'required'"
              :error="errors.has('numero_mtr')"
              :error-message="errors.first('numero_mtr')"
            />
          </div>
          <div class="col col-sm-10 col-xs-12">
            <q-input
              v-model="model.terceiro"
              label="Nome do Terceiro"
              data-vv-name="nome"
              :error="errors.has('nome')"
              :error-message="errors.first('nome')"
            />
          </div>
          <div class="col col-sm-2 col-xs-12">
            <q-select
              :options="MTRGerado"
              v-model="selectMTRGerado"
              label="MTR Gerado"
              data-vv-name="mtr_gerado"
              v-validate="'required'"
              :error="errors.has('mtr_gerado')"
              :error-message="errors.first('mtr_gerado')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-select
              :options="MtrGerarCertificado"
              v-model="selectMtrGerarCertificado"
              label="MTR precisa gerar certificado"
              data-vv-name="gerar_certificado"
              v-validate="'required'"
              :error="errors.has('gerar_certificado')"
              :error-message="errors.first('gerar_certificado')"
            />
          </div>
          <div class="col col-sm-7 col-xs-12">
            <q-select
              :options="clientesEnderecos"
              v-model="selectClientesEnderecos"
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
    submitting: false,
    MTRGerado: [],
    selectMTRGerado: {
      label: '',
      value: ''
    },
    clientesEnderecos: [],
    selectClientesEnderecos: {
      label: '',
      value: ''
    },
    MtrGerarCertificado: [],
    selectMtrGerarCertificado: {
      label: '',
      value: ''
    }
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
    }

  },
  mounted () {
    this.getData()
    this.$store.dispatch('clientesEnderecos/loadList',
      {
        where: {
          cliente_id: this.model.ordem_servico.orcamento.cliente_id
        }
      }).then((data) => {
      this.clientesEnderecos = data.data.map(data => {
        if (parseInt(data.id) === parseInt(this.model.ordem_servico.endereco_id)) {
          this.selectClientesEnderecos.value = data.id
          this.selectClientesEnderecos.label = data.endereco + ' ' + data.numero + ' - ' + data.bairro
        }
        return {
          label: data.endereco,
          value: data.id
        }
      }
      )
    })
    this.MTRGerado = this.$store.state.mtrs.MtrGerado.map(data => {
      if (data.value === this.model.dono) {
        this.selectMTRGerado.value = data.value
        this.selectMTRGerado.label = data.label
      }
      return {
        label: data.label,
        value: data.value
      }
    })
    this.MtrGerarCertificado = this.$store.state.mtrs.MtrGerarCertificado.map(data => {
      if (data.value === this.model.certificado) {
        this.selectMtrGerarCertificado.value = data.value
        this.selectMtrGerarCertificado.label = data.label
      }
      return {
        label: data.label,
        value: data.value
      }
    })
  }
}
</script>

<style>
</style>
