export default {
  module: {
    singular: 'Cliente',
    plural: 'Clientes',
    url: 'clientes',
    icon: 'fa fa-align-justify',
    btn: {
      new: 'Novo Cliente',
      edit: 'Editar o Cliente',
      del: 'Excluir Clientes'
    }
  },
  filter: '',
  item: {},
  list: [],
  currentId: '',
  loading: true,
  tipos: [
    {
      label: 'Pessoa Jurídica',
      value: 1
    },
    {
      label: 'Pessoa Física',
      value: 2
    }
  ]
}
