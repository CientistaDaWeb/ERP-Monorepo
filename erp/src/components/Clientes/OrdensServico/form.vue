<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-6 col-xs-12">
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
          <div class="col col-sm-6 col-xs-12">
            <q-select
              :options="empresa"
              v-model="model.empresa"
              label="Empresa"
              data-vv-name="empresa"
              v-validate="'required'"
              :error="errors.has('empresa')"
              :error-message="errors.first('empresa')"
            />
          </div>
          <div class="col col-sm-6 col-xs-12">
            <q-select
              :options="transportador"
              v-model="model.transportador"
              label="Transportador"
              data-vv-name="transportador"
              v-validate="'required'"
              :error="errors.has('transportador')"
              :error-message="errors.first('transportador')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              v-model="model.data_coleta"
              label="Data de Coleta"
              data-vv-name="data_coleta"
              v-validate="'required'"
              :error="errors.has('data_coleta')"
              :error-message="errors.first('data_coleta')"
            >
              <template v-slot:append>
                <q-icon
                  name="fa fa-calendar"
                  class="cursor-pointer"
                >
                  <q-popup-proxy
                    transition-show="scale"
                    ref="qDateProxy"
                    transition-hide="scale"
                  >
                    <q-date
                      today-btn
                      mask="DD/MM/YYYY"
                      v-model="model.data_coleta"
                      @input="() => $refs.qDateProxy.hide()"
                    />
                  </q-popup-proxy>
                </q-icon>
              </template>
            </q-input>
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              type="time"
              v-model="model.hora_coleta"
              label="Hora Coleta"
              data-vv-name="hora_coleta"
              v-validate="'required'"
              :error="errors.has('hora_coleta')"
              :error-message="errors.first('hora_coleta')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              mask="#.##"
              fill-mask="0"
              reverse-fill-mask
              prefix="R$"
              v-model="model.valor"
              label="Valor"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              mask="#.##"
              fill-mask="0"
              reverse-fill-mask
              prefix="R$"
              v-model="model.desconto"
              label="Desconto"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-select
              :options="numero_coletas"
              v-model="model.numero_coletas"
              label="Nº Coletas Programadas"
              data-vv-name="numero_coletas"
              v-validate="'required'"
              :error="errors.has('numero_coletas')"
              :error-message="errors.first('numero_coletas')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-select
              :options="status"
              v-model="model.status"
              label="Status"
              data-vv-name="status"
              v-validate="'required'"
              :error="errors.has('status')"
              :error-message="errors.first('status')"
            />
          </div>
          <div class="col col-sm-12 col-xs-12">
            <q-input
              type="textarea"
              rows="3"
              v-model="model.obs_coleta"
              label="Observações"
              data-vv-name="obs_coleta"
              v-validate="'required'"
              :error="errors.has('obs_coleta')"
              :error-message="errors.first('obs_coleta')"
            />
          </div>
        </div>
        <div class="row q-col-gutter-md">
          <div class="col col-sm-3 col-xs-12">
            <q-input
              v-model="model.ordem_compra"
              label="Ordem de Compra"
              data-vv-name="ordem_compra"
              v-validate="'required'"
              :error="errors.has('ordem_compra')"
              :error-message="errors.first('ordem_compra')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-select
              :options="tipo_reservatorio"
              v-model="model.tipo_reservatorio"
              label="Tipo de Reservatório"
              data-vv-name="tipo_reservatorio"
              v-validate="'required'"
              :error="errors.has('tipo_reservatorio')"
              :error-message="errors.first('tipo_reservatorio')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-select
              :options="ponto_coleta"
              v-model="model.ponto_coleta"
              label="Acesso Ponto de Coleta"
              data-vv-name="ponto_coleta"
              v-validate="'required'"
              :error="errors.has('ponto_coleta')"
              :error-message="errors.first('ponto_coleta')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              v-model="model.metragem_mangueira"
              label="Metragem de Mangueira Necessária"
              data-vv-name="metragem_mangueira"
              v-validate="'required'"
              :error="errors.has('metragem_mangueira')"
              :error-message="errors.first('metragem_mangueira')"
            />
          </div>
          <div class="col col-sm-9 col-xs-12">
            <q-input
              v-model="model.situacao_tampas"
              label="Situação das Tampas"
              data-vv-name="situacao_tampas"
              v-validate="'required'"
              :error="errors.has('situacao_tampas')"
              :error-message="errors.first('situacao_tampas')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-select
              :options="situacao_efluentes"
              v-model="model.situacao_efluentes"
              label="Situação dos Efluentes"
              data-vv-name="situacao_efluentes"
              v-validate="'required'"
              :error="errors.has('situacao_efluentes')"
              :error-message="errors.first('situacao_efluentes')"
            />
          </div>
          <div class="col col-sm-12 col-xs-12">
            <q-input
              type="textarea"
              rows="3"
              v-model="model.obs_pos_coleta"
              label="Observações Pós Coleta"
              data-vv-name="obs_pos_coleta"
              v-validate="'required'"
              :error="errors.has('obs_pos_coleta')"
              :error-message="errors.first('obs_pos_coleta')"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-input
              v-model="model.horas_trabalhadas"
              label="Horas Trabalhadas"
              data-vv-name="horas_trabalhadas"
              v-validate="'required'"
              :error="errors.has('horas_trabalhadas')"
              :error-message="errors.first('horas_trabalhadas')"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-select
              :options="checagem_final"
              v-model="model.checagem_final"
              label="Checagem Final"
              data-vv-name="checagem_final"
              v-validate="'required'"
              :error="errors.has('checagem_final')"
              :error-message="errors.first('checagem_final')"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-select
              :options="faturada"
              v-model="model.faturada"
              label="Faturada"
              data-vv-name="faturada"
              v-validate="'required'"
              :error="errors.has('faturada')"
              :error-message="errors.first('faturada')"
            />
          </div>
          <div class="col col-sm-12 col-xs-12">
            <q-input
              type="textarea"
              rows="3"
              v-model="model.obs_faturamento"
              label="Observações para Faturamento"
              data-vv-name="obs_faturamento"
              v-validate="'required'"
              :error="errors.has('obs_faturamento')"
              :error-message="errors.first('obs_faturamento')"
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
              @click="$router.push({name:'ordens-servico.index'})"
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
  QSelect,
  QInput,
  QDate,
  QPopupProxy
} from 'quasar'
import _ from 'lodash'
export default {
  name: 'OrdensServicoForm',
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
    QSelect,
    QInput,
    QDate,
    QPopupProxy
  },
  data: () => ({
    submitting: false
  }),
  methods: {
    getData () {
      if (this.id) {
        this.$store.dispatch('ordensServico/loadItem', this.id)
      } else {
        this.$store.commit('ordensServico/setItem', {})
      }
      this.$store.dispatch('endereco/loadList', {})
      this.$store.dispatch('empresa/loadList', {})
      this.$store.dispatch('transportador/loadList', {})
      this.$store.dispatch('numero_coletas/loadList', {})
      this.$store.dispatch('status/loadList', {})
      this.$store.dispatch('tipo_reservatorio/loadList', {})
      this.$store.dispatch('ponto_coleta/loadList', {})
      this.$store.dispatch('situacao_efluentes/loadList', {})
      this.$store.dispatch('checagem_final/loadList', {})
      this.$store.dispatch('faturada/loadList', {})
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
              endereco: this.model.endereco,
              empresa: this.model.empresa,
              transportador: this.model.transportador,
              data_coleta: this.model.data_coleta,
              hora_coleta: this.model.hora_coleta,
              valor: this.model.valor,
              desconto: this.model.desconto,
              numero_coletas: this.model.numero_coletas,
              status: this.model.status,
              obs_coleta: this.model.obs_coleta,
              ordem_compra: this.model.ordem_compra,
              tipo_reservatorio: this.model.tipo_reservatorio,
              ponto_coleta: this.model.ponto_coleta,
              metragem_mangueira: this.model.metragem_mangueira,
              situacao_tampas: this.model.situacao_tampas,
              situacao_efluentes: this.model.situacao_efluentes,
              obs_pos_coleta: this.model.obs_pos_coleta,
              horas_trabalhadas: this.model.horas_trabalhadas,
              checagem_final: this.model.checagem_final,
              faturada: this.model.faturada,
              obs_faturamento: this.model.obs_faturamento
            }
            if (this.action === 'edit') {
              this.$store.dispatch('ordensServico/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('ordensServico/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'ordens-servico.editar',
                    params: { id: this.$store.state.ordensServico.currentId }
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
      return this.$store.state.ordensServico.item
    },
    endereco () {
      return _.orderBy(this.$store.state.endereco.list.map(
        data =>
          ({
            label: data.rua,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    empresa () {
      return _.orderBy(this.$store.state.empresa.list.map(
        data =>
          ({
            label: data.empresa,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    transportador () {
      return _.orderBy(this.$store.state.transportador.list.map(
        data =>
          ({
            label: data.transportador,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    numero_coletas () {
      return _.orderBy(this.$store.state.numero_coletas.list.map(
        data =>
          ({
            label: data.numero_coleta,
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
    tipo_reservatorio () {
      return _.orderBy(this.$store.state.tipo_reservatorio.list.map(
        data =>
          ({
            label: data.tipo_reservatorio,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    ponto_coleta () {
      return _.orderBy(this.$store.state.ponto_coleta.list.map(
        data =>
          ({
            label: data.ponto_coleta,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    situacao_efluentes () {
      return _.orderBy(this.$store.state.situacao_efluentes.list.map(
        data =>
          ({
            label: data.situacao_efluente,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    checagem_final () {
      return _.orderBy(this.$store.state.checagem_final.list.map(
        data =>
          ({
            label: data.checagem_final,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    faturada () {
      return _.orderBy(this.$store.state.faturada.list.map(
        data =>
          ({
            label: data.faturada,
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
