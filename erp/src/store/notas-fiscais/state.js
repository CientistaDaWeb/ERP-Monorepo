export default {
  module: {
    singular: 'Nota Fiscal',
    plural: 'Notas Fiscais',
    url: 'notas-fiscais',
    icon: 'fa fa-align-justify',
    btn: {
      new: 'Nova Nota Fiscal',
      edit: 'Editar a Nota Fiscal',
      del: 'Excluir Notas Fiscais'
    }
  },
  filter: '',
  item: {},
  list: [],
  currentId: '',
  loading: true,
  tipos: {
    S: 'Serviços',
    P: 'Projetos'
  },
  tiposOptions: [
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
