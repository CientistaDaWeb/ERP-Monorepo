export default {
  module: {
    singular: 'Ordens de Serviço',
    plural: 'Ordens de Serviço',
    url: 'ordens-servico',
    icon: 'fa fa-align-justify',
    btn: {
      new: 'Nova Ordem de Serviço',
      edit: 'Editar a Ordem de Serviço',
      del: 'Excluir Ordens de Serviço'
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
    1: 'Aguardando',
    2: 'Executando',
    3: 'Concluido',
    4: 'Cancelada',
    5: 'Cortesia'
  },
  statusOptions: [
    {
      value: 1,
      label: 'Aguardando'
    },
    {
      value: 2,
      label: 'Executando'
    },
    {
      value: 3,
      label: 'Concluido'
    },
    {
      value: 4,
      label: 'Cancelada'
    },
    {
      value: 5,
      label: 'Cortesia'
    }
  ],
  colors: {
    1: 'warning',
    2: 'warning',
    3: 'success',
    4: 'error',
    5: 'success'
  },
  tipoReservatorio: [
    {
      value: 'F',
      label: 'FOSSA'
    },
    {
      value: 'I',
      label: 'FILTRO'
    },
    {
      value: 'FF',
      label: 'FOSSA/FILTRO'
    },
    {
      value: 'T',
      label: 'TANQUE'
    },
    {
      value: 'B',
      label: 'BOMBONA'
    },
    {
      value: 'O',
      label: 'OUTROS'
    }
  ],
  acesso: [
    {
      value: 'D',
      label: 'DIFÍCIL'
    },
    {
      value: 'R',
      label: 'REGULAR'
    },
    {
      value: 'F',
      label: 'FÁCIL'
    }
  ],
  situacaoEfluentes: [
    {
      value: 'N',
      label: 'RESÍDUO NORMAL'
    },
    {
      value: 'M',
      label: 'RESÍDUO COM MISTURAS'
    },
    {
      value: 'A',
      label: 'RESÍDUO ALTERADO'
    }
  ],
  checagemFinal: [
    {
      value: 'L',
      label: 'LACRE DA FOSSA'
    },
    {
      value: 'L',
      label: 'LIMPEZA DO LOCAL'
    },
    {
      value: 'M',
      label: 'MTR'
    },
    {
      value: 'F',
      label: 'FICHA DE EMERGÊNCIA'
    },
    {
      value: 'E',
      label: "EPI's"
    },
    {
      value: 'P',
      label: 'PLACAS'
    }
  ],
  faturado: [
    {
      value: 'N',
      label: 'Não'
    },
    {
      value: 'S',
      label: 'Sim'
    }
  ],
  coletasOptions: [
    {
      value: 1,
      label: '1'
    },
    {
      value: 2,
      label: '2'
    },
    {
      value: 3,
      label: '3'
    },
    {
      value: 4,
      label: '4'
    },
    {
      value: 5,
      label: '5'
    },
    {
      value: 6,
      label: '6'
    }
  ]
}
