<template>
  <div class="q-pa-md q-gutter-sm">
    <q-btn color="primary" label="Ver Orçamento" @click="verOrcamento"></q-btn>
    <q-btn color="primary" label="Download Orçamento" @click="downloadOrcamento"></q-btn>
    <q-btn color="primary" label="Enviar Email" @click="dialogEmail = true"></q-btn>
    <q-dialog v-model="dialogEmail">
      <q-card style="width: 100%;">
        <q-card-section class="row items-center">
          <div class="text-h6">Enviar Orçamento por E-mail</div>
          <q-space />
          <q-btn icon="fas fa-times" flat round dense @click="dialogEmail = false"/>
        </q-card-section>
        <q-card-section>
          <q-form
            @reset="onReset"
            class="q-gutter-md"
          >
            <q-input
              ref="email"
              v-model="formEmail.destinatarios"
              label="Destinatários"
              :dense="true"
              autofocus
              :rules="[val => !!val || '* Requerido']"
              lazy-rules
              @focus="$refs.email.resetValidation()"
              hint="email1@email.com,email2@email.com,..."
            />
            <q-select
              v-model="selectAssunto"
              @input="trocaAssunto"
              :options="optAssunto"
              label="Assunto"
              emit-value
              map-options
            />
            <q-input
              v-model="formEmail.assunto"
              :dense="true"
              ref="assunto"
              :rules="[val => !!val || '* Requerido']"
              lazy-rules
              @focus="$refs.assunto.resetValidation()"
            />
            <q-select
              v-model="selectDescricao"
              @input="trocaDescricao"
              :options="optDesc"
              label="Descrição"
              emit-value
              map-options
            />
            <q-input
              v-model="formEmail.descricao"
              type="textarea"
              ref="descricao"
              :rules="[val => !!val || '* Requerido']"
              lazy-rules
              @focus="$refs.descricao.resetValidation()"
            />
            <q-btn @click="onSubmit" color="primary" label="Enviar"></q-btn>
            <q-btn type="reset" color="primary" label="Limpar"></q-btn>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
  </div>
</template>

<script>
import { QBtn, Notify, Loading, QDialog, QCard, QCardSection, QSpace, QForm, QInput, QSelect } from 'quasar'
import axios from 'axios'
export default {
  props: ['orcamento_id'],
  name: 'OrcamentoVisualizar',
  components: { QBtn, QDialog, QCard, QCardSection, QSpace, QForm, QInput, QSelect },
  data: () => ({
    dialogEmail: false,
    formEmail: {
      id: null,
      destinatarios: null,
      assunto: null,
      descricao: null
    },
    selectDescricao: null,
    selectAssunto: null,
    optAssunto: [],
    optDesc: []
  }),
  methods: {
    onSubmit () {
      this.formEmail.id = this.orcamento_id
      this.$refs.email.validate()
      this.$refs.assunto.validate()
      this.$refs.descricao.validate()
      this.formHasError = false
      if (this.$refs.email.hasError || this.$refs.assunto.hasError || this.$refs.descricao.hasError) {
        this.formHasError = true
      }
      if (!this.formHasError) {
        const url = `${process.env.DATA_URL}api/orcamentos-servicos/email`
        const dados = this.formEmail
        Loading.show({
          customClass: '',
          backgroundColor: 'dark',
          message: 'Enviando...'
        })
        axios.post(url, dados).then(res => {
          Loading.hide()
          let color = 'positive'
          if (res.data.erro) {
            color = 'negative'
          }
          Notify.create({
            message: res.data.msg,
            color: color,
            icon: 'fa fa-check-circle'
          })
        }).catch(error => {
          Loading.hide()
          Notify.create({
            message: 'Erro ao enviar e-mail: ' + error.response.data.message,
            color: 'negative',
            icon: 'fa fa-check-circle'
          })
        })
      }
    },
    trocaDescricao () {
      this.formEmail.descricao = this.selectDescricao
      this.$refs.descricao.resetValidation()
    },
    trocaAssunto () {
      this.formEmail.assunto = this.selectAssunto
      this.$refs.assunto.resetValidation()
    },
    pegaTextos () {
      const url = `${process.env.DATA_URL}api/orcamentos-servicos/pega-textos`
      axios.get(url).then(res => {
        if (res.data.erro === 0) {
          this.optAssunto.push({ label: 'Usar Modelo', value: null })
          for (const texto of res.data.assuntos.textos) {
            this.optAssunto.push({ label: texto.titulo, value: texto.descricao })
          }
          this.optDesc.push({ label: 'Usar Modelo', value: null })
          for (const texto of res.data.descricao.textos) {
            this.optDesc.push({ label: texto.titulo, value: texto.descricao })
          }
        } else {
          console.log(res.data.msg)
        }
      }).catch(error => {
        Notify.create({
          message: 'Erro ao buscar o textos: ' + error.response.data.message,
          color: 'negative',
          icon: 'fa fa-check-circle'
        })
      })
    },
    onReset () {
      for (const key in this.formEmail) {
        this.formEmail[key] = null
      }
    },
    verOrcamento () {
      this.pdfOrcamento()
    },
    downloadOrcamento () {
      this.pdfOrcamento(1)
    },
    pdfOrcamento (down = null) {
      const url = `${process.env.DATA_URL}api/orcamentos-servicos/visualizar/${this.orcamento_id}`
      axios.get(url).then(res => {
        let a = document.createElement('a')
        a.href = `${process.env.DATA_URL}api/orcamentos-servicos/download/${res.data.arq}`
        if (!down) {
          a.href = `${process.env.DATA_URL}/${res.data.arq}.pdf`
          a.target = '_blank'
        }
        console.log(a.href)
        a.click()
      }).catch(error => {
        Notify.create({
          message: 'Erro ao buscar o orçamento ' + this.orcamento_id + ': ' + error.response.data.message,
          color: 'negative',
          icon: 'fa fa-check-circle'
        })
      })
    }
  },
  mounted () {
    this.pegaTextos()
  }
}
</script>

<style>
</style>
