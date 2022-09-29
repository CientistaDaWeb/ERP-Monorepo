import VueCurrency from 'vue-currency-filter'

export default ({
  Vue
}) => {
  Vue.use(VueCurrency, {
    symbol: 'R$',
    thousandsSeparator: '.',
    fractionCount: 2,
    fractionSeparator: ',',
    symbolPosition: 'front',
    symbolSpacing: true
  })
}
