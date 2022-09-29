export function findValue (value, values) {
  // Convert nested levels to array
  let keys = value.toString().split('.')
  let val
  // If it has only one level we take the first key and find it in values
  if (keys.length === 1) {
    const firstKey = keys[0]
    val = values[firstKey]
    // Otherwise we should check in the next nested level
  } else if (keys.length > 1) {
    const firstKey = JSON.parse(JSON.stringify(keys[0]))
    let objectProperty = values[firstKey]
    keys = keys.slice(1)
    if (typeof objectProperty === 'undefined') {
      val = null
    } else {
      // Remove the first item of keys because we have already accessed
      keys.forEach((key, index) => {
        if ((index + 1) === keys.length) {
          if (typeof objectProperty === 'undefined') {
            val = null
          } else {
            val = objectProperty[key]
          }
        } else {
          if (typeof objectProperty === 'undefined') {
            val = null
          } else {
            objectProperty = objectProperty[key]
          }
        }
      })
    }
  }

  return val
}
