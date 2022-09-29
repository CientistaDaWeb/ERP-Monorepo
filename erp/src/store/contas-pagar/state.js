export default {
  module: {
    singular: 'Conta a Pagar',
    plural: 'Contas a Pagar',
    url: 'contas-pagar',
    icon: 'fa fa-align-justify',
    btn: {
      new: 'Nova Conta a Pagar',
      edit: 'Editar a Conta a Pagar',
      del: 'Excluir a Conta a Pagar'
    }
  },
  filter: '',
  item: {},
  list: [],
  currentId: '',
  loading: true,
  listAtrasadas: [],
  listVencendo: [],
  status: {
    pago: 'success',
    aberto: 'warning',
    atrasada: 'error'
  },
  statusOptions: [
    {
      label: 'Pago',
      value: 'pago'
    },
    {
      label: 'Aberto',
      value: 'aberto'
    },
    {
      label: 'Atrasada',
      value: 'atrasada'
    }
  ],
  contaFixa: {
    1: 'Fixa',
    2: 'Variável'
  },
  contaFixaOptions: [
    {
      label: 'Fixa',
      value: 1
    },
    {
      label: 'Variável',
      value: 2
    }
  ]
}
