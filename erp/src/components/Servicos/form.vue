<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-4 col-xs-12">
            <q-select
              filter
              :options="categorias"
              v-model="model.categoria_id"
              label="Categoria"
              data-vv-name="Categoria"
              v-validate="'required'"
              :error="errors.has('Categoria')"
              :error-message="errors.first('Categoria')"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-input
              v-model="model.servico"
              label="Serviço"
              data-vv-name="Serviço"
              v-validate="'required'"
              :error="errors.has('Serviço')"
              :error-message="errors.first('Serviço')"
            />
          </div>
          <div class="col col-sm-4 col-xs-12">
            <q-input
              prefix="R$ "
              type="number"
              v-model="model.valor_unitario"
              label="Valor Unitário"
              data-vv-name="Valor Unitário"
              v-validate="'required'"
              :error="errors.has('Valor Unitário')"
              :error-message="errors.first('Valor Unitário')"
            />
          </div>
          <div class="col col-sm-5 col-xs-12">
            <q-input
              type="textarea"
              rows="3"
              v-model="model.descricao"
              label="Descrição"
              data-vv-name="Descrição"
              v-validate="'required'"
              :error="errors.has('Descrição')"
              :error-message="errors.first('Descrição')"
            />
          </div>
          <div class="col col-sm-2 col-xs-12">
            <q-select
              :options="certificados"
              v-model="model.certificado"
              label="Gera Certificado"
              data-vv-name="Gera Certificado"
              v-validate="'required'"
              :error="errors.has('Gera Certificado')"
              :error-message="errors.first('Gera Certificado')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-select
              :options="tipos"
              v-model="model.tipo"
              label="Tipo de Resíduo"
              data-vv-name="Tipo de Resíduo"
              v-validate="'required'"
              :error="errors.has('Tipo de Resíduo')"
              :error-message="errors.first('Tipo de Resíduo')"
            />
          </div>
          <div class="col col-sm-2 col-xs-12">
            <q-input
              v-model="model.unidade"
              label="Unidade de Medida"
              data-vv-name="Unidade de Medida"
              v-validate="'required'"
              :error="errors.has('Unidade de Medida')"
              :error-message="errors.first('Unidade de Medida')"
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
              @click="$router.push({name:'servicos.index'})"
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
  name: 'ServicosForm',
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
    submitting: false,
    money: {
      decimal: ',',
      thousands: '.',
      prefix: 'R$ ',
      suffix: '',
      precision: 2
    }
  }),
  methods: {
    getData () {
      if (this.id) {
        this.$store.dispatch('servicos/loadItem', this.id)
      } else {
        this.$store.commit('servicos/setItem', {})
      }
      this.$store.dispatch('servicosCategorias/loadList', {})
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
              categoria_id: this.model.categoria_id,
              servico: this.model.servico,
              valor_unitario: this.model.valor_unitario,
              descricao: this.model.descricao,
              certificado: this.model.certificado,
              tipo: this.model.tipo,
              unidade: this.model.unidade
            }
            console.log(data.valor_unitario)
            if (this.action === 'edit') {
              this.$store.dispatch('servicos/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('servicos/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'servicos.editar',
                    params: { id: this.$store.state.servicos.currentId }
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
      return this.$store.state.servicos.item
    },
    categorias () {
      return _.orderBy(this.$store.state.servicosCategorias.list.map(
        data =>
          ({
            label: data.categoria,
            value: data.id
          })
      ), 'label', 'ASC')
    },
    tipos () {
      return this.$store.state.servicos.tipos
    },
    certificados () {
      return this.$store.state.servicos.certificados
    }
  },
  mounted () {
    this.getData()
  }
}
</script>

<style>
</style>
