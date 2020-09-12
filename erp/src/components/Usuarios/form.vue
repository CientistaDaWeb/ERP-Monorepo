<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-sm-3 col-xs-12">
            <q-select
              :options="ativo"
              v-model="selectAtivo"
              label="Ativo no Sistema"
              data-vv-name="ativo"
              v-validate="'required'"
              :error="errors.has('ativo')"
              :error-message="errors.first('ativo')"
            />
          </div>
          <div class="col col-sm-9 col-xs-12">
            <q-input
              v-model="model.nome"
              label="Nome"
              data-vv-name="nome"
              v-validate="'required'"
              :error="errors.has('nome')"
              :error-message="errors.first('nome')"
            />
          </div>
          <div class="col col-sm-7 col-xs-12">
            <q-input
              v-model="model.usuario"
              label="Usuário"
              data-vv-name="usuario"
              v-validate="'required'"
              :error="errors.has('usuario')"
              :error-message="errors.first('usuario')"
            />
          </div>
          <div class="col col-sm-5 col-xs-12">
            <q-input
              type="password"
              v-model="model.senha"
              label="Senha"
              data-vv-name="senha"
              :error="errors.has('senha')"
              :error-message="errors.first('senha')"
            />
          </div>
          <div class="col col-sm-6 col-xs-12">
            <q-input
              v-model="model.cargo"
              label="Cargo"
              data-vv-name="cargo"
              :error="errors.has('cargo')"
              :error-message="errors.first('cargo')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              v-model="model.pis"
              label="PIS"
              data-vv-name="pis"
              :error="errors.has('pis')"
              :error-message="errors.first('pis')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-input
              v-model="model.telefone"
              label="Telefone"
              data-vv-name="telefone"
              v-validate="'required'"
              :error="errors.has('telefone')"
              :error-message="errors.first('telefone')"
            />
          </div>
          <div class="col col-sm-9 col-xs-12">
            <q-input
              v-model="model.email"
              label="E-mail"
              data-vv-name="email"
              v-validate="'required'"
              :error="errors.has('email')"
              :error-message="errors.first('email')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-select
              :options="ponto"
              v-model="selectPonto"
              label="Usa o Ponto?"
              data-vv-name="ponto"
              v-validate="'required'"
              :error="errors.has('ponto')"
              :error-message="errors.first('ponto')"
            />
          </div>
          <div class="col col-sm-9 col-xs-12">
            <q-input
              v-model="model.token"
              label="Token"
              data-vv-name="token"
              v-validate="'required'"
              :error="errors.has('token')"
              :error-message="errors.first('token')"
            />
          </div>
          <div class="col col-sm-3 col-xs-12">
            <q-select
              :options="administrador"
              v-model="selectAdministrador"
              label="Administrador"
              data-vv-name="administrador"
              v-validate="'required'"
              :error="errors.has('administrador')"
              :error-message="errors.first('administrador')"
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
              @click="$router.push({name:'usuarios.index'})"
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
// import _ from 'lodash'
export default {
  name: 'UsuariosForm',
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
    administrador: [],
    selectAdministrador: {
      value: '',
      label: ''
    },
    ativo: [],
    selectAtivo: {
      value: '',
      label: ''
    },
    ponto: [],
    selectPonto: {
      value: '',
      label: ''
    }
  }),
  methods: {
    getData () {
      if (this.id) {
        this.$store.dispatch('usuarios/loadItem', this.id)
      } else {
        this.$store.commit('usuarios/setItem', {})
      }
      // this.$store.dispatch('ativo/loadList', {})
      // this.$store.dispatch('ponto/loadList', {})
      // this.$store.dispatch('administrador/loadList', {})
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
              ativo: this.selectAtivo.value,
              nome: this.model.nome,
              usuario: this.model.usuario,
              senha: this.model.senha,
              cargo: this.model.cargo,
              pis: this.model.pis,
              telefone: this.model.telefone,
              email: this.model.email,
              ponto: this.selectPonto.value,
              token: this.model.token,
              administrador: this.selectAdministrador.value
            }
            if (this.action === 'edit') {
              console.log(data)
              this.$store.dispatch('usuarios/updateItem', { data: data, id: this.id })
            } else {
              this.$store.dispatch('usuarios/saveItem', data)
                .then(() => {
                  this.$router.push({
                    name: 'usuarios.editar',
                    params: { id: this.$store.state.usuarios.currentId }
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
      return this.$store.state.usuarios.item
    }
    // ativo () {
    //   return _.orderBy(this.$store.state.ativo.list.map(
    //     data =>
    //       ({
    //         label: data.ativo,
    //         value: data.id
    //       })
    //   ), 'label', 'ASC')
    // },
    // ponto () {
    //   return _.orderBy(this.$store.state.ponto.list.map(
    //     data =>
    //       ({
    //         label: data.ponto,
    //         value: data.id
    //       })
    //   ), 'label', 'ASC')
    // },
    // administrador () {
    //   return _.orderBy(this.$store.state.administrador.list.map(
    //     data =>
    //       ({
    //         label: data.administrador,
    //         value: data.id
    //       })
    //   ), 'label', 'ASC')
    // }
  },
  mounted () {
    this.getData()
    console.log(this.model)
    this.administrador = this.$store.state.usuarios.papel.map(data => {
      if (data.value === this.model.papel) {
        this.selectAdministrador.value = data.value
        this.selectAdministrador.label = data.label
      }
      return {
        label: data.label,
        value: data.value
      }
    })
    this.ativo = this.$store.state.usuarios.ativo.map(data => {
      if (data.value === this.model.ativo) {
        this.selectAtivo.value = data.value
        this.selectAtivo.label = data.label
      }
      return {
        label: data.label,
        value: data.value
      }
    })
    this.ponto = this.$store.state.usuarios.ponto.map(data => {
      if (data.value === this.model.ponto) {
        this.selectPonto.value = data.value
        this.selectPonto.label = data.label
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
