<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-md-3 col-xs-12">
            <q-select
              :options="categoria"
              v-model="model.categoria"
              label="Categoria"
              data-vv-name="categoria"
              v-validate="'required'"
              :error="errors.has('categoria')"
              :error-message="errors.first('categoria')"
            />
          </div>
          <div class="col col-md-9 col-xs-12">
            <q-input
              v-model="model.protocolo"
              label="Número do Protocolo"
              data-vv-name="protocolo"
              v-validate="'required'"
              :error="errors.has('protocolo')"
              :error-message="errors.first('protocolo')"
            />
          </div>
          <div class="col col-md-6 col-xs-12">
            <q-input
              v-model="model.nome"
              label="Nome do Projeto"
              data-vv-name="nome"
              v-validate="'required'"
              :error="errors.has('nome')"
              :error-message="errors.first('nome')"
            />
          </div>
          <div class="col col-md-6 col-xs-12">
            <q-input
              v-model="model.proprietario"
              label="Proprietário"
              data-vv-name="proprietario"
              v-validate="'required'"
              :error="errors.has('proprietario')"
              :error-message="errors.first('proprietario')"
            />
          </div>
          <div class="col col-md-3 col-xs-12">
            <q-select
              :options="arquiteto"
              v-model="model.arquiteto"
              label="Arquiteto"
              data-vv-name="arquiteto"
              v-validate="'required'"
              :error="errors.has('arquiteto')"
              :error-message="errors.first('arquiteto')"
            />
          </div>
          <div class="col col-md-3 col-xs-12">
            <q-select
              :options="construtora"
              v-model="model.construtora"
              label="Construtora"
              data-vv-name="construtora"
              v-validate="'required'"
              :error="errors.has('construtora')"
              :error-message="errors.first('construtora')"
            />
          </div>
          <div class="col col-md-6 col-xs-12">
            <q-input
              v-model="model.endereco"
              label="Endereço"
              data-vv-name="endereco"
              v-validate="'required'"
              :error="errors.has('endereco')"
              :error-message="errors.first('endereco')"
            />
          </div>
          <div class="col col-md-12 col-xs-12">
            <q-input
              type="textarea"
              rows="3"
              v-model="model.obs"
              label="Observações"
              data-vv-name="obs"
              :error="errors.has('obs')"
              :error-message="errors.first('obs')"
            />
          </div>
          <div class="col col-md-8 col-xs-12">
            <q-input
              v-model="model.diretorio"
              label="Diretório"
              data-vv-name="diretorio"
              :error="errors.has('diretorio')"
              :error-message="errors.first('diretorio')"
            />
          </div>
          <div class="col col-md-2 col-xs-12">
            <q-select
              :options="status"
              v-model="model.status"
              label="Status do PPCI"
              data-vv-name="status"
              :error="errors.has('status')"
              :error-message="errors.first('status')"
            />
          </div>
          <div class="col col-md-2 col-xs-12">
            <q-select
              :options="hidro"
              v-model="model.hidro"
              label="Status do Hidro"
              data-vv-name="hidro"
              :error="errors.has('hidro')"
              :error-message="errors.first('hidro')"
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
              @click="$router.push({name:'projetos.index'})"
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
  name: 'ProjetosForm',
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
        this.$store.dispatch('projetos/loadItem', this.id)
      } else {
        this.$store.commit('projetos/setItem', {})
      }
      this.$store.dispatch('categoria/loadList', {})
      this.$store.dispatch('arquiteto/loadList', {})
      this.$store.dispatch('construtora/loadList', {})
      this.$store.dispatch('status/loadList', {})
      this.$store.dispatch('hidro/loadList', {})
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
              categoria: this.model.categoria,
              protocolo: this.model.protocolo,
              nome: this.model.nome,
              proprietario: this.model.proprietario,
              arquiteto: this.model.arquiteto,
              construtora: this.model.construtora,
              endereco: this.model.endereco,
              obs: this.model.obs,
              diretorio: this.model.diretorio,
              status: this.model.status,
              hidro: this.model.hidro
            }
            if (this.action === 'edit') {
              this.$store.dispatch('projetos/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('projetos/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'projetos.editar',
                    params: { id: this.$store.state.projetos.currentId }
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
      return this.$store.state.projetos.item
    },
    categoria () {
      return _.orderBy(this.$store.state.categoria.list.map(
        data =>
          ({
            label: data.categoria,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    arquiteto () {
      return _.orderBy(this.$store.state.arquiteto.list.map(
        data =>
          ({
            label: data.arquiteto,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    construtora () {
      return _.orderBy(this.$store.state.construtora.list.map(
        data =>
          ({
            label: data.construtora,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    status () {
      return _.orderBy(this.$store.state.status.list.map(
        data =>
          ({
            label: data.status,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    hidro () {
      return _.orderBy(this.$store.state.hidro.list.map(
        data =>
          ({
            label: data.hidro,
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
