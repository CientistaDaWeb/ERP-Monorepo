export default {
  module: {
    singular: 'Orçamento',
    plural: 'Orçamentos',
    url: 'orcamentos',
    icon: 'fa fa-align-justify',
    btn: {
      new: 'Novo Orçamento',
      edit: 'Editar o Orçamento',
      del: 'Excluir Orçamentos'
    }
  },
  filter: '',
  item: {
    empresa_id: 0
  },
  list: [],
  currentId: '',
  loading: true,
  listAbertos: [],
  listDivergencias: [],
  status: {
    1: 'Rascunho',
    2: 'Aguardando Aprovação',
    3: 'Aprovado',
    4: 'Não Aprovado'
  },
  statusOptions: [
    {
      value: 1,
      label: 'Rascunho'
    },
    {
      value: 2,
      label: 'Aguardando Aprovação'
    },
    {
      value: 3,
      label: 'Aprovado'
    },
    {
      value: 4,
      label: 'Não Aprovado'
    }
  ],
  colors: {
    1: 'warning',
    2: 'warning',
    3: 'success',
    4: 'error'
  },
  vantagens: {
    S: 'Sim',
    N: 'Não'
  },
  vantagensOptions: [
    {
      value: 'S',
      label: 'Sim'
    },
    {
      value: 'N',
      label: 'Não'
    }
  ]
}
