<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-2 col-xs-12">
            <q-select
              :options="tipos"
              v-model="model.documento_tipo"
              label="Tipo"
              data-vv-name="Tipo"
              v-validate="'required'"
              :error="errors.has('Tipo')"
              :error-message="errors.first('tipo')"
            />
          </div>
          <div class="col col-sm-2 col-xs-12">
            <q-input
              v-model="model.documento"
              label="Dcoumento"
              data-vv-name="Documento"
              v-validate="'required'"
              :error="errors.has('Documento')"
              :error-message="errors.first('Documento')"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-input
              v-model="model.razao_social"
              label="Razão Social"
              data-vv-name="Razão Social"
              v-validate="'required'"
              :error="errors.has('Razão Social')"
              :error-message="errors.first('Razão Social')"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-input
              v-model="model.nome_fantasia"
              label="Nome Fantasia"
              data-vv-name="Nome Fantasia"
              v-validate="'required'"
              :error="errors.has('Nome Fantasia')"
              :error-message="errors.first('Nome Fantasia')"
            />
          </div>
          <div class="col col-sm-2 col-xs-12">
            <q-input
              type="number"
              v-model="model.inscricao_estadual"
              label="Inscrição Estadual"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-input
              v-model="model.contato"
              label="Contato"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              type="email"
              v-model="model.email"
              label="E-mail"
              data-vv-name="E-mail"
              v-validate="'required|email'"
              :error="errors.has('E-mail')"
              :error-message="errors.first('E-mail')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              type="email"
              v-model="model.email_cobrança"
              label="E-mail de Cobrança"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              type="email"
              v-model="model.email_pesquisa"
              label="E-mail de Pesquisa"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              type="url"
              v-model="model.site"
              label="Site"
            />
          </div>
          <div class="col col-sm-2 col-xs-12">
            <q-input
              type="number"
              v-model="model.numero_fepan"
              label="Número da Fepan"
            />
          </div>
          <div class="col col-sm-2 col-xs-12">
            <q-input
              v-model="model.sindico"
              label="Síndico"
            />
          </div>
          <div class="col col-sm-2 col-xs-12">
            <q-input
              v-model="model.zelador"
              label="Zelador"
            />
          </div>
          <div class="col col-sm-6 col-xs-12">
            <q-select
              filter
              :options="administradores"
              v-model="model.administrador_id"
              label="Administrador de Condomínio"
              data-vv-name="Admnistrador de Condomínio"
              v-validate="'required'"
              :error="errors.has('Administrador de Condomínio')"
              :error-message="errors.first('Administrador de Condomínio')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              v-model="model.usuario"
              label="Usuário"
              data-vv-name="Usuário"
              v-validate="'required'"
              :error="errors.has('Usuário')"
              :error-message="errors.first('Usuário')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              v-model="model.senha"
              label="Senha"
              data-vv-name="Senha"
              v-validate="'required'"
              :error="errors.has('Senha')"
              :error-message="errors.first('Senha')"
            />
          </div>
          <div class="col col-sm-6 col-xs-12">
            <q-input
              type="textarea"
              rows="5"
              v-model="model.observacoes"
              label="Observações"
            />
          </div>
          <div class="col col-sm-6 col-xs-12">
            <q-input
              type="textarea"
              rows="5"
              v-model="model.observacoes_faturamento"
              label="Observações de Faturamento"
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
              @click="$router.push({name:'clientes.index'})"
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
  name: 'ClientesForm',
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
        this.$store.dispatch('clientes/loadItem', this.id)
      } else {
        this.$store.commit('clientes/setItem', {})
      }
      this.$store.dispatch('administradoresCondominio/loadList', {})
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
              documento_tipo: this.model.documento_tipo,
              documento: this.model.documento,
              razao_social: this.model.razao_social,
              nome_fantasia: this.model.nome_fantasia,
              inscricao_estadual: this.model.inscricao_estadual,
              contato: this.model.contato,
              email: this.model.email,
              email_cobranca: this.model.email_cobranca,
              email_pesquisa: this.model.email_pesquisa,
              site: this.model.site,
              numero_fepan: this.model.numero_fepan,
              sindico: this.model.sindico,
              zelador: this.model.zelador,
              administrador_id: this.model.administrador_id,
              usuario: this.model.usuario,
              senha: this.model.senha,
              observacoes: this.model.observacoes,
              observacoes_faturamento: this.model.observacoes_faturamento
            }
            if (this.action === 'edit') {
              this.$store.dispatch('clientes/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('clientes/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'clientes.editar',
                    params: { id: this.$store.state.clientes.currentId }
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
      return this.$store.state.clientes.item
    },
    tipos () {
      return this.$store.state.clientes.tipos
    },
    administradores () {
      return _.orderBy(this.$store.state.administradoresCondominio.list.map(
        data =>
          ({
            label: data.nome,
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
