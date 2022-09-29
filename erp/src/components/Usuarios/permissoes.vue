<template>
  <form @submit.prevent="save">
    <div class="row q-col-gutter-md">
      <div class="col col-xs-12">
        <div class="row q-col-gutter-md">
          <div class="col col-md-12 col-xs-12">
            <q-checkbox
              v-model="financeiro"
              label="FINANCEIRO"
            />
          </div>
          <div class="col col-md-12 col-xs-12">
            <q-option-group
              class="q-pl-md"
              :options="optFinanceiro"
              type="checkbox"
              v-model="grpFinanceiro"
            />
          </div>
          <div class="col col-md-12 col-xs-12">
            <q-checkbox
              v-model="orcamentos"
              label="ORÇAMENTOS"
            />
          </div>
          <div class="col col-md-12 col-xs-12">
            <q-option-group
              class="q-pl-md"
              :options="optOrcamentos"
              type="checkbox"
              v-model="grpOrcamentos"
            />
          </div>
          <div class="col col-md-12 col-xs-12">
            <q-checkbox
              v-model="clientes"
              label="CLIENTES"
            />
          </div>
          <div class="col col-md-12 col-xs-12">
            <q-option-group
              class="q-pl-md"
              :options="optClientes"
              type="checkbox"
              v-model="grpClientes"
            />
          </div>
          <div class="col col-md-12 col-xs-12">
            <q-checkbox
              v-model="servicos"
              label="SERVIÇOS"
            />
          </div>
          <div class="col col-md-12 col-xs-12">
            <q-option-group
              class="q-pl-md"
              :options="optServicos"
              type="checkbox"
              v-model="grpServicos"
            />
          </div>
          <div class="col col-md-12 col-xs-12">
            <q-checkbox
              v-model="administrativo"
              label="ADMINISTRATIVO"
            />
          </div>
          <div class="col col-md-12 col-xs-12">
            <q-option-group
              class="q-pl-md"
              :options="optAdministrativo"
              type="checkbox"
              v-model="grpAdministrativo"
            />
          </div>
          <div class="col col-md-12 col-xs-12">
            <q-checkbox
              v-model="fornecedores"
              label="FORNECEDORES"
            />
          </div>
          <div class="col col-md-12 col-xs-12">
            <q-option-group
              class="q-pl-md"
              :options="optFornecedores"
              type="checkbox"
              v-model="grpFornecedores"
            />
          </div>
          <div class="col col-md-12 col-xs-12">
            <q-checkbox
              v-model="agenda"
              label="AGENDA"
            />
          </div>
          <div class="col col-md-12 col-xs-12">
            <q-option-group
              class="q-pl-md"
              :options="optAgenda"
              type="checkbox"
              v-model="grpAgenda"
            />
          </div>
          <div class="col col-md-12 col-xs-12">
            <q-checkbox
              v-model="relatorios"
              label="RELATÓRIOS"
            />
          </div>
          <div class="col col-md-12 col-xs-12">
            <q-option-group
              class="q-pl-md"
              :options="optRelatorios"
              type="checkbox"
              v-model="grpRelatorios"
            />
          </div>
          <div class="col col-md-12 col-xs-12">
            <q-checkbox
              v-model="caminhao"
              label="CAMINHÃO"
            />
          </div>
          <div class="col col-md-12 col-xs-12">
            <q-option-group
              class="q-pl-md"
              :options="optCaminhao"
              type="checkbox"
              v-model="grpCaminhao"
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
  QOptionGroup,
  QCheckbox
} from 'quasar'

export default {
  name: 'PermissoesForm',
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
    QOptionGroup,
    QCheckbox
  },
  data: () => ({
    submitting: false,
    grpFinanceiro: [],
    financeiro: false,
    optFinanceiro: [
      { label: 'Categorias de Contas a Pagar', value: '' },
      { label: 'Empresas', value: '' },
      { label: 'Bancos', value: '' },
      { label: 'Formas de Pagamento', value: '' },
      { label: 'Contas a Pagar', value: '' },
      { label: 'Contas a Receber', value: '' },
      { label: 'Investimentos', value: '' },
      { label: 'Retornos Itaú', value: '' },
      { label: 'Remessas Itaú', value: '' },
      { label: 'CT-e', value: '' },
      { label: 'Ct-e Acqualife', value: '' },
      { label: 'Ct-e Acquaservicos', value: '' }
    ],
    grpOrcamentos: [],
    orcamentos: false,
    optOrcamentos: [
      { label: 'Orçamentos', value: '' },
      { label: 'Ordens de Serviço', value: '' },
      { label: 'MTRs', value: '' },
      { label: 'Certificados', value: '' },
      { label: 'Contratos', value: '' },
      { label: 'Notas Fiscais', value: '' },
      { label: 'Notas Fiscais de Projetos', value: '' }
    ],
    grpClientes: [],
    clientes: false,
    optClientes: [
      { label: 'Clientes', value: '' },
      { label: 'Categorias de Telefones', value: '' },
      { label: 'Categorias de Endereços', value: '' },
      { label: 'Administradores de Condomínios', value: '' },
      { label: 'Pesquisa de Satisfação', value: '' },
      { label: 'Categorias de Clientes', value: '' },
      { label: 'Mapa de Condomínios', value: '' }
    ],
    grpServicos: [],
    servicos: false,
    optServicos: [
      { label: 'Serviços', value: '' },
      { label: 'Categorias de Serviços', value: '' },
      { label: 'Projetos', value: '' },
      { label: 'Categoria de Projetos', value: '' }
    ],
    grpAdministrativo: [],
    administrativo: false,
    optAdministrativo: [
      { label: 'Módulos', value: '' },
      { label: 'Categorias de Módulos', value: '' },
      { label: 'Logs de alterações', value: '' },
      { label: 'Usuários', value: '' },
      { label: 'Estados', value: '' },
      { label: 'Categorias de Textos', value: '' },
      { label: 'Textos', value: '' },
      { label: 'Logs de Acesso', value: '' },
      { label: 'Livro Ponto', value: '' },
      { label: 'CFOP', value: '' },
      { label: 'Municipios', value: '' },
      { label: 'Categoria de Arquivos de Empresas', value: '' }
    ],
    grpFornecedores: [],
    fornecedores: false,
    optFornecedores: [
      { label: 'Categorias de Fornecedores', value: '' },
      { label: 'Fornecedores', value: '' },
      { label: 'Transportadores', value: '' },
      { label: 'Construtoras', value: '' },
      { label: 'Arquitetos', value: '' }
    ],
    grpAgenda: [],
    agenda: false,
    optAgenda: [
      { label: 'Compromissos', value: '' },
      { label: 'Ordens de Serviços', value: '' },
      { label: 'Viel', value: '' },
      { label: 'Folgas', value: '' }
    ],
    grpRelatorios: [],
    relatorios: false,
    optRelatorios: [
      { label: 'Fluxo de Caixa', value: '' },
      { label: 'Ordem de Serviço', value: '' },
      { label: 'Orçamentos', value: '' },
      { label: 'Atendimentos', value: '' },
      { label: 'Contas a Pagar', value: '' },
      { label: 'Contas a Receber', value: '' },
      { label: 'Clientes por Administrador de Condomínio', value: '' },
      { label: 'Contratos', value: '' },
      { label: 'Notas Fiscais', value: '' },
      { label: 'Notas Fiscais de Projetos', value: '' },
      { label: 'Demonstrativo de Resultado', value: '' },
      { label: 'Clientes', value: '' },
      { label: 'Livro Ponto', value: '' },
      { label: 'Projetos', value: '' },
      { label: 'Compromissos', value: '' },
      { label: 'CT-e', value: '' },
      { label: 'Pesquisa de Satisfação', value: '' },
      { label: 'Clientes Atendidos', value: '' },
      { label: 'Clientes Cadastrados', value: '' },
      { label: 'Resíduos', value: '' },
      { label: 'Manutenção Caminhão', value: '' },
      { label: 'Ct-e Acqualife', value: '' },
      { label: 'Ct-e Acquaserviços', value: '' }
    ],
    grpCaminhao: [],
    caminhao: false,
    optCaminhao: [
      { label: 'Abastecimentos', value: '' },
      { label: 'Peças', value: '' },
      { label: 'Manutenção', value: '' },
      { label: 'Aditivos', value: '' },
      { label: 'Caminhões', value: '' }
    ]
  }),
  methods: {
    getData () {
      if (this.id) {
        this.$store.dispatch('usuarios/loadItem', this.id)
      } else {
        this.$store.commit('usuarios/setItem', {})
      }
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
              nome: this.model.nome
            }
            if (this.action === 'edit') {
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
  },
  mounted () {
    this.getData()
  }
}
</script>

<style>
</style>
