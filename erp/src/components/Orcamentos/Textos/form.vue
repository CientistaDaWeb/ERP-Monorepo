<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-6 col-xs-12">
            <q-select
              :options="titulos"
              v-model="model.titulo_id"
              label="Template de Título"
              @input="mudaTitulo"
              class="q-mb-md"
              emit-value
              map-options
            />
            <q-input
              label="Título"
              v-model="model.titulo"
              type="textarea"
              rows="7"
            />
          </div>
          <div class="col col-sm-6 col-xs-12">
            <q-select
              :options="condicoes"
              v-model="model.condicao_id"
              label="Template de Condições de Pagamento"
              @input="mudaCondicao"
              class="q-mb-md"
              emit-value
              map-options
            />
            <q-input
              label="Condições Pagamento"
              v-model="model.condicoes_pagamento"
              type="textarea"
              rows="7"
            />
          </div>
          <div class="col col-sm-6 col-xs-12">
            <q-select
              :options="validades"
              v-model="model.validade_id"
              label="Template de Validade da Proposta"
              @input="mudaValidade"
              class="q-mb-md"
              emit-value
              map-options
            />
            <q-input
              label="Validade da Proposta"
              v-model="model.prazo_entrega"
              type="textarea"
              rows="7"
            />
          </div>
          <div class="col col-sm-6 col-xs-12">
            <q-select
              :options="observacoes"
              v-model="model.observacao_id"
              label="Template de Observações"
              @input="mudaObservacao"
              class="q-mb-md"
              emit-value
              map-options
            />
            <q-input
              label="Observacoes"
              v-model="model.observacoes"
              type="textarea"
              rows="7"
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
              @click="$router.push({name:'orcamentos.index'})"
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
  name: 'OrcamentosTextosForm',
  props: {
    id: {
      type: Number,
      required: true
    }
  },
  components: {
    QInput,
    QBtn,
    QSelect
  },
  data: () => ({
    submitting: false,
    titulos: [],
    condicoes: [],
    validades: [],
    observacoes: [],
    model: {
      titulo_id: '',
      condicao_id: '',
      validade_id: '',
      observacao_id: ''
    }
  }),
  methods: {
    getData () {
      if (this.id) {
        this.$store.dispatch('orcamentos/loadItem', this.id)
      } else {
        this.$store.commit('orcamentos/setItem', {})
      }
      this.$store.dispatch('textos/loadList',
        {
          where: {
            categoria_id: 8
          }
        })
        .then((data) => {
          this.titulos = _.orderBy(data.data.map(
            data =>
              ({
                label: data.titulo,
                value: data.id
              })
          ), 'label', 'ASC')
        })
      this.$store.dispatch('textos/loadList',
        {
          where: {
            categoria_id: 1
          }
        })
        .then((data) => {
          this.condicoes = _.orderBy(data.data.map(
            data =>
              ({
                label: data.titulo,
                value: data.id
              })
          ), 'label', 'ASC')
        })
      this.$store.dispatch('textos/loadList',
        {
          where: {
            categoria_id: 2
          }
        })
        .then((data) => {
          this.validades = _.orderBy(data.data.map(
            data =>
              ({
                label: data.titulo,
                value: data.id
              })
          ), 'label', 'ASC')
        })
      this.$store.dispatch('textos/loadList',
        {
          where: {
            categoria_id: 3
          }
        })
        .then((data) => {
          this.observacoes = _.orderBy(data.data.map(
            data =>
              ({
                label: data.titulo,
                value: data.id
              })
          ), 'label', 'ASC')
        })
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
              titulo: this.model.titulo,
              condicoes_pagamento: this.model.condicoes_pagamento,
              prazo_entrega: this.model.prazo_entrega,
              observacoes: this.model.observacoes
            }
            this.$store.dispatch('orcamentos/updateItem', { data: data, id: this.id })
            this.$validator.reset()
            this.submitting = false
          }
        })
    },
    mudaTitulo () {
      if (this.model.titulo_id) {
        this.$store.dispatch('textos/loadItem', this.model.titulo_id)
          .then((data) => {
            this.model.titulo = data.descricao
          })
      }
    },
    mudaCondicao () {
      if (this.model.condicao_id) {
        this.$store.dispatch('textos/loadItem', this.model.condicao_id)
          .then((data) => {
            this.model.condicoes_pagamento = data.descricao
          })
      }
    },
    mudaValidade () {
      if (this.model.validade_id) {
        this.$store.dispatch('textos/loadItem', this.model.validade_id)
          .then((data) => {
            this.model.prazo_entrega = data.descricao
          })
      }
    },
    mudaObservacao () {
      if (this.model.observacao_id) {
        this.$store.dispatch('textos/loadItem', this.model.observacao_id)
          .then((data) => {
            this.model.observacoes = data.descricao
          })
      }
    }
  },
  mounted () {
    this.getData()
  }
}
</script>

<style>
</style>
