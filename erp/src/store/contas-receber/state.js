export default {
  module: {
    singular: 'Conta a Receber',
    plural: 'Contas a Receber',
    url: 'contas-receber',
    icon: 'fa fa-align-justify',
    btn: {
      new: 'Nova Conta a Receber',
      edit: 'Editar a Conta a Receber',
      del: 'Excluir a Conta a Receber'
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
  parcelas: [
    { value: 1, label: '1' },
    { value: 2, label: '2' },
    { value: 3, label: '3' },
    { value: 4, label: '4' },
    { value: 5, label: '5' },
    { value: 6, label: '6' },
    { value: 7, label: '7' },
    { value: 8, label: '8' },
    { value: 9, label: '9' },
    { value: 10, label: '10' },
    { value: 11, label: '11' },
    { value: 12, label: '12' }
  ],
  periodicidades: [
    {
      value: 30,
      label: 'Mensal'
    },
    {
      value: 15,
      label: 'Quinzenal'
    },
    {
      value: 7,
      label: 'Semanal'
    }
  ]
}
