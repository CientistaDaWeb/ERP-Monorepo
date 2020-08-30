export default {
  module: {
    singular: 'Efluente',
    plural: 'Efluentes',
    url: 'servicos',
    icon: 'fa fa-align-justify',
    btn: {
      new: 'Novo Efluente',
      edit: 'Editar o Efluente',
      del: 'Excluir Efluentes'
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
      label: 'Nenhum',
      value: '0'
    },
    {
      label: 'Industrial',
      value: '1'
    },
    {
      label: 'Fossa Séptica',
      value: '2'
    },
    {
      label: 'Fossa Séptica e Gordura',
      value: '3'
    }
  ]
}
