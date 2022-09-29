export default {
  module: {
    singular: 'Cliente CRM',
    plural: 'Clientes CRM',
    url: 'clientes-crm',
    icon: 'fa fa-align-justify',
    btn: {
      new: 'Novo Atendimento do Cliente',
      edit: 'Editar o Atendimento do Cliente',
      del: 'Excluir Atendimentos do Clientes'
    }
  },
  filter: '',
  item: {},
  list: [],
  currentId: '',
  loading: true,
  listAbertos: [],
  status: {
    R: 'Resolvido',
    A: 'Aguardando'
  },
  statusOptions: [
    {
      label: 'Resolvido',
      value: 'R'
    },
    {
      label: 'Aguardando',
      value: 'A'
    }
  ]
}
