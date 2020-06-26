import * as VueGoogleMaps from 'vue2-google-maps'

export default ({
  Vue
}) => {
  Vue.use(VueGoogleMaps, {
    load: {
      key: 'AIzaSyDOq0I_ojSB7fWPlOiaPidErlXpoqxD2p0',
      libraries: 'places'
    }
  })
}
