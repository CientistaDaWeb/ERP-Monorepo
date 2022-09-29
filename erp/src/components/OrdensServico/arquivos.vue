<template>
  <div class="row q-col-gutter-md">
    <div class="col col-xs-12">
      <div class="row q-col-gutter-md items-center">
        <div class="col col-md-12 col-xs-12 text-center">
          Arquivos
        </div>
        <div class="col col-md-12 col-xs-12 text-center">
          <q-separator />
        </div>
        <div class="col col-md-2 col-xs-12">
          Visualização
        </div>
        <div class="col col-md-8 col-xs-12">
          X Arquivo Não Gerado
        </div>
        <div class="col col-md-2 col-xs-12">
          <q-btn
            type="submit"
            loading="submitting"
            color="positive"
            glossy
            label="Gerar PDF"
          />
        </div>
        <div class="col col-md-2 col-xs-12">
          Relatório
        </div>
        <div class="col col-md-8 col-xs-12">
          X Arquivo Não Gerado
        </div>
        <div class="col col-md-2 col-xs-12">
          <q-btn
            type="submit"
            loading="submitting"
            color="positive"
            glossy
            label="Gerar PDF"
          />
        </div>
        <div class="col col-md-12 col-xs-12 text-center">
          Dados
        </div>
        <div class="col col-md-12 col-xs-12 text-center">
          <q-separator />
        </div>
        <div class="col col-md-2 col-xs-12">
          E-Mail
        </div>
        <div class="col col-md-10 col-xs-12">
          <q-input
            data-vv-name="email"
            v-validate="'required'"
            :error="errors.has('email')"
            :error-message="errors.first('email')"
          />
        </div>
        <div class="col col-md-2 col-xs-12">
          Assunto
        </div>
        <div class="col col-md-5 col-xs-12">
          <q-select
            v-model="modelo"
            :options="options"
            data-vv-name="modelo"
            v-validate="'required'"
            :error="errors.has('modelo')"
            :error-message="errors.first('modelo')"
          />
        </div>
        <div class="col col-md-5 col-xs-12">
          <q-input
            data-vv-name="assunto"
            v-validate="'required'"
            :error="errors.has('assunto')"
            :error-message="errors.first('assunto')"
          />
        </div>
        <div class="col col-md-2 col-xs-12">
          Menssagem
        </div>
        <div class="col col-md-5 col-xs-12">
          <q-select
            v-model="modelo"
            :options="options"
            data-vv-name="modelo"
            v-validate="'required'"
            :error="errors.has('modelo')"
            :error-message="errors.first('modelo')"
          />
        </div>
        <div class="col col-md-5 col-xs-12">
          <q-input
            type="textarea"
            rows="3"
            data-vv-name="mensagem"
            v-validate="'required'"
            :error="errors.has('mensagem')"
            :error-message="errors.first('mensagem')"
          />
        </div>
      </div>
      <div class="row q-col-gutter-md">
        <div class="col col-md-12 col-xs-12 text-center">
          <q-btn
            type="submit"
            :loading="submitting"
            color="positive"
            glossy
            label="Enviar Arquivos"
            icon="fa fa-save"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {
  QBtn,
  QSeparator,
  QInput,
  QSelect
} from 'quasar'
export default {
  name: 'OrdemServicoArquivos',
  components: {
    QBtn,
    QSeparator,
    QInput,
    QSelect
  },
  computed: {
    options () {
      return ['Usar Modelo', 'CÓPIA ORDEM DE SERVIÇO - ACQUASANA', 'RELATÓRIO DE COLETA']
    },
    modelo () {
      return 'Usar Modelo'
    }

  }
}
</script>
