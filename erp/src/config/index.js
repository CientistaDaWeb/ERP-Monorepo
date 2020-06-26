import {
  findValue
} from 'src/utils'
import api from './api'
import auth from './auth'

export default function (value = '', fallback = null) {
  const values = {
    api,
    auth
  }
  return findValue(value, values) || fallback
}
