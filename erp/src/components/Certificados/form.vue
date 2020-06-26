<template>
  <div class="row q-col-gutter-md">
    <div class="col col-xs-12">
      <div class="row q-col-gutter-md">
        <div class="col col-sm-2 col-xs-12">
          <q-input
            type="number"
            v-model="model.sequencial"
            label="Sequencial"
            v-validate="'required'"
            :error="errors.has('sequencial')"
            :error-message="errors.first('sequencial')"
          />
        </div>
        <div class="col col-sm-4 col-xs-12">
          <q-input
            mask="#.#"
            fill-mask="0"
            reverse-fill-mask
            v-model="model.quantidade"
            label="Quantidade"
            v-validate="'required'"
            :error="errors.has('quantidade')"
            :error-message="errors.first('quantidade')"
          />
        </div>
        <div class="col col-sm-6 col-xs-12">
          <q-input
            v-model="model.cliente"
            label="Cliente"
            data-vv-name="cliente"
            v-validate="'required'"
            :error="errors.has('cliente')"
            :error-message="errors.first('cliente')"
          />
        </div>
        <div class="col col-sm-6 col-xs-12">
          <q-input
            v-model="model.endereco"
            label="Endereço do Cliente"
            data-vv-name="endereco"
            v-validate="'required'"
            :error="errors.has('endereco')"
            :error-message="errors.first('endereco')"
          />
        </div>
        <div class="col col-sm-6 col-xs-12">
          <q-input
            v-model="model.cidade"
            label="Cidade do Cliente"
            data-vv-name="cidade"
            v-validate="'required'"
            :error="errors.has('cidade')"
            :error-message="errors.first('cidade')"
          />
        </div>
        <div class="col col-sm-6 col-xs-12">
          <q-input
            v-model="model.transportador"
            label="Transportador"
            data-vv-name="transportador"
            v-validate="'required'"
            :error="errors.has('transportador')"
            :error-message="errors.first('transportador')"
          />
        </div>
        <div class="col col-sm-6 col-xs-12">
          <q-input
            v-model="model.endereco_transp"
            label="Endereço do Transportador"
            data-vv-name="endereco_transp"
            v-validate="'required'"
            :error="errors.has('endereco_transp')"
            :error-message="errors.first('endereco_transp')"
          />
        </div>
        <div class="col col-sm-3 col-xs-12">
          <q-select
            :options="lo_transp"
            v-model="model.lo_transp"
            label="LO do Transportador"
            data-vv-name="lo_transp"
            v-validate="'required'"
            :error="errors.has('lo_transp')"
            :error-message="errors.first('lo_transp')"
          />
        </div>
        <div class="col col-sm-3 col-xs-12">
          <q-select
            :options="tipo_efluente"
            v-model="model.tipo_efluente"
            label="Tipo de Efluente"
            data-vv-name="tipo_efluente"
            v-validate="'required'"
            :error="errors.has('tipo_efluente')"
            :error-message="errors.first('tipo_efluente')"
          />
        </div>
        <div class="col col-sm-3 col-xs-12">
          <q-input
            v-model="model.data_inicio"
            label="Inicio do Tratamento"
            data-vv-name="data_inicio"
            v-validate="'required'"
            :error="errors.has('data_inicio')"
            :error-message="errors.first('data_inicio')"
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
                    v-model="model.data_inicio"
                    @input="() => $refs.qDateProxy.hide()"
                  />
                </q-popup-proxy>
              </q-icon>
            </template>
          </q-input>
        </div>
        <div class="col col-sm-3 col-xs-12">
          <q-input
            v-model="model.data_fim"
            label="Fim do Tratamento"
            data-vv-name="data_fim"
            v-validate="'required'"
            :error="errors.has('data_fim')"
            :error-message="errors.first('data_fim')"
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
                    v-model="model.data_fim"
                    @input="() => $refs.qDateProxy.hide()"
                  />
                </q-popup-proxy>
              </q-icon>
            </template>
          </q-input>
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
</template>

<script>
import {
  date,
  QInput,
  QBtn,
  QSelect,
  QDate,
  QPopupProxy,
  QIcon
} from 'quasar'
import _ from 'lodash'
import moment from 'moment'
export default {
  name: 'CertificadosForm',
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
    QSelect,
    QDate,
    QPopupProxy,
    QIcon
  },
  data: () => ({
    submitting: false
  }),
  methods: {
    getData () {
      if (this.id) {
        this.$store.dispatch('certificados/loadItem', this.id)
      } else {
        this.$store.commit('certificados/setItem', {})
      }
      this.$store.dispatch('transportadores/loadList', {})
      // this.$store.dispatch('tipo_efluente/loadList', {})
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
              sequencial: this.model.sequencial,
              quantidade: this.model.quantidade,
              cliente: this.model.cliente,
              endereco: this.model.endereco,
              cidade: this.model.cidade,
              transportador: this.model.transportador,
              endereco_transp: this.model.endereco_transp,
              lo_transp: this.model.lo_transp,
              tipo_efluente: this.model.tipo_efluente,
              data_inicio: date.formatDate(this.model.data_inicio, 'YYYY-MM-DD'),
              data_fim: date.formatDate(this.model.data_fim, 'YYYY-MM-DD')
            }
            if (this.action === 'edit') {
              this.$store.dispatch('certificados/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('certificados/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'certificados.editar',
                    params: { id: this.$store.state.certificados.currentId }
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
      let store = this.$store.state.certificados.item
      if (store.data_inicio) {
        store.data_inicio = date.formatDate(moment(store.data_inicio), 'DD/MM/YYYY')
      }
      if (store.data_fim) {
        store.data_fim = date.formatDate(moment(store.data_fim), 'DD/MM/YYYY')
      }
      return store
    },
    lo_transp () {
      return _.orderBy(this.$store.state.transportadores.list.map(
        data =>
          ({
            label: data.transp,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    tipo_efluente () {
      return _.orderBy(this.$store.state.tipo_efluente.list.map(
        data =>
          ({
            label: data.efluente,
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
