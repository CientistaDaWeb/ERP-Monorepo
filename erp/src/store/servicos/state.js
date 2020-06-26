export default {
  module: {
    singular: 'Serviço',
    plural: 'Servicos',
    url: 'servicos',
    icon: 'fa fa-align-justify',
    btn: {
      new: 'Novo Serviço',
      edit: 'Editar o Serviço',
      del: 'Excluir Serviços'
    }
  },
  filter: '',
  item: {},
  list: [],
  currentId: '',
  loading: true,
  certificados: [
    {
      label: 'Sim',
      value: 'S'
    },
    {
      label: 'Não',
      value: 'N'
    }
  ],
  tipos: [
    {
      label: 'Genérico',
      value: 'G'
    },
    {
      label: 'Resíduo',
      value: 'R'
    },
    {
      label: 'Resíduo Doméstico',
      value: 'D'
    },
    {
      label: 'Resíduo Industrial',
      value: 'I'
    },
    {
      label: 'Transporte',
      value: 'T'
    }
  ]
}
