import VueMoney from 'v-money'

export default ({
  Vue
}) => {
  Vue.use(VueMoney, {
    decimal: ',',
    thousands: '.',
    prefix: 'R$ ',
    suffix: ' #',
    precision: 2
  })
}
