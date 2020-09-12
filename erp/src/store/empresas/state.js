export default {
  module: {
    singular: 'Empresa',
    plural: 'Empresas',
    url: 'empresas',
    icon: 'fa fa-align-justify',
    btn: {
      new: 'Nova Empresa',
      edit: 'Editar a Empresa',
      del: 'Excluir Empresas'
    }
  },
  filter: '',
  item: {},
  list: [],
  currentId: '',
  loading: true,
  tipos: [
    {
      label: 'Serviços',
      value: 'S'
    },
    {
      label: 'Projetos',
      value: 'P'
    }
  ]
}
