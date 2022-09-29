<template>
  <div class="row q-col-gutter-md">
    <div class="col col-xs-12">
      <div class="row q-col-gutter-md items-center">
        <div class="col col-md-3 col-xs-12">
          Categoria
        </div>
        <div class="col col-md-5 col-xs-12">
          Serviço
        </div>
        <div class="col col-md-2 col-xs-12">
          Quantidade
        </div>
        <div class="col col-md-2 col-xs-12">
          Valor
        </div>
        <div class="col col-md-12 col-xs-12">
          <q-separator />
        </div>
        <div class="col col-md-3 col-xs-12">
          Coleta de Efluente
        </div>
        <div class="col col-md-5 col-xs-12">
          Coleta e Tratamento - Efluente Doméstico
        </div>
        <div class="col col-md-2 col-xs-12">
          <q-input
            mask="#.#"
            fill-mask="0"
            reverse-fill-mask
            v-model="model.quantidade"
          />
        </div>
        <div class="col col-md-2 col-xs-12">
          <q-input
            mask="#.##"
            fill-mask="0"
            reverse-fill-mask
            v-model="model.valor"
          />
        </div>
        <div class="col col-md-3 col-xs-12">
          Coleta de Efluente
        </div>
        <div class="col col-md-5 col-xs-12">
          Coleta e Tratamento - Efluente de Gordura
        </div>
        <div class="col col-md-2 col-xs-12">
          <q-input
            mask="#.#"
            fill-mask="0"
            reverse-fill-mask
            v-model="model.quantidade"
          />
        </div>
        <div class="col col-md-2 col-xs-12">
          <q-input
            mask="#.##"
            fill-mask="0"
            reverse-fill-mask
            v-model="model.valor"
          />
        </div>
        <div class="col col-md-3 col-xs-12">
          Transportes
        </div>
        <div class="col col-md-5 col-xs-12">
          Transporte de Efluente - ETE
        </div>
        <div class="col col-md-2 col-xs-12">
          <q-input
            mask="#.#"
            fill-mask="0"
            reverse-fill-mask
            v-model="model.quantidade"
          />
        </div>
        <div class="col col-md-2 col-xs-12">
          <q-input
            mask="#.##"
            fill-mask="0"
            reverse-fill-mask
            v-model="model.valor"
          />
        </div>
        <div class="col col-md-12 col-xs-12">
          <q-separator />
        </div>
        <div class="col col-md-10 col-xs-12 text-center">
          Total
        </div>
        <div class="col col-md-2 col-xs-12">
          <q-input
            mask="#.#"
            fill-mask="0"
            reverse-fill-mask
            v-model="model.total"
          />
        </div>
      </div>
      <div class="row  q-col-gutter-md">
        <div class="col col-xs-12 text-center">
          <q-btn
            type="submit"
            :loading="submiting"
            color="positive"
            glossy
            label="Salvar"
            icon="fa fa-save"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {
  QInput,
  QBtn,
  QSeparator
} from 'quasar'
export default {
  name: 'OrdemServicoServico',
  components: {
    QInput, QBtn, QSeparator
  },
  data () {
    return {
      submiting: false
    }
  },
  computed: {
    model () {
      return this.$store.state.ordensServico.item
    }
  }
}
</script>
