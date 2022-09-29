export function urlEncodeSearch (params, type) {
  let str = []
  if (params) {
    for (let index in params) {
      if (params.hasOwnProperty(index)) {
        if (typeof (params[index]) === 'object') {
          for (let index2 in params[index]) {
            if (params[index].hasOwnProperty(index2)) {
              if (typeof (params[index][index2]) === 'object') {
                console.log(params[index][index2][3])
                for (let index3 in params[index][index2]) {
                  if (params[index][index2].hasOwnProperty(index3)) {
                    str.push(type + '[' + encodeURIComponent(index) + '][' + encodeURIComponent(index2) + '][' + encodeURIComponent(index3) + ']=' + encodeURIComponent(params[index][index2][index3]))
                  }
                }
              } else {
                str.push(type + '[' + encodeURIComponent(index) + '][' + encodeURIComponent(index2) + ']' + '=' + encodeURIComponent(params[index][index2]))
              }
            }
          }
        } else {
          str.push(type + '[' + encodeURIComponent(index) + ']' + '=' + encodeURIComponent(params[index]))
        }
      }
    }
    return '&' + str.join('&')
  }
  return ''
}
