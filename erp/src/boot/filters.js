// import something here
import moment from 'moment'

// leave the export, even if you don't use it
export default ({ Vue }) => {
  Vue.filter('formatDate',
    function (value, format) {
      if (value) {
        return moment(String(value)).format(format)
      }
    }
  )
  Vue.filter('compactAddress',
    function (value) {
      if (value) {
        return value.endereco + ', ' + value.numero + ' ' + value.complemento + ' - ' + value.municipio.nome
      }
    }
  )
  Vue.filter('formatPhones',
    function (value) {
      if (value) {
        let phones = []
        value.forEach(function (phone) {
          if (phone) {
            if (phone.hasOwnProperty('telefone')) {
              phone = phone.telefone
            }
            let phoneFormated = formatPhone(phone)
            phones.push(phoneFormated)
          }
        })
        if (phones.length > 0) {
          return phones.join(' ')
        }
        return '-'
      } else {
        return '-'
      }
    }
  )
  Vue.filter('formatPhone',
    function (value) {
      if (value) {
        return formatPhone(value)
      }
    }
  )
  Vue.filter('isset',
    function (value) {
      try {
        if (value !== null || value !== 'undefined') {
          return value
        }
      } catch (e) {
        console.log(value)
        return false
      }
    }
  )
}

function formatPhone (phone) {
  let phoneDigits = phone.replace(/\D/g, '')
  return '<div class="q-chip row no-wrap inline items-center q-chip-small bg-primary text-white q-mt-xs">' +
    '<div class="q-chip-side q-chip-left row flex-center">' +
    '<i aria-hidden="true" class="q-icon q-chip-icon fa fa-phone"> </i>' +
    '</div>' +
    '<div class="q-chip-main ellipsis">' +
    '<a href="tel:+55' + phoneDigits + '" class="telefone">' + phone + '</a>' +
    '</div></div>'
}
