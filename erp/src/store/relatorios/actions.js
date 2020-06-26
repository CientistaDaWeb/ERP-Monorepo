import axios from 'axios'
import { Notify } from 'quasar'

export const relatorio = ({ commit, state }, payload) => {
  const module = state.module
  const url = `${process.env.DATA_URL}api/${module.url}/${payload.relatorio}`
  commit('setContent', [])
  commit('setLoading', true)
  return axios
    .get(url, { params: payload.data })
    .then(({ data }) => {
      commit('setLoading', false)
      commit('setContent', data)
    })
    .catch(error => {
      commit('setLoading', false)
      Notify.create({
        message: 'Erro ao buscar o relatório ' + relatorio + '! ' + error.response.data.message,
        color: 'negative',
        icon: 'fa fa-check-circle'
      })
    })
}

export const csv = ({ commit, state }, payload) => {
  const module = state.module
  const url = `${process.env.DATA_URL}api/${module.url}/${payload.relatorio}`
  commit('setLoading', true)
  return axios
    .get(url, { params: payload.data })
    .then(({ data }) => {
      commit('setLoading', false)
      commit('setArqCsv', data.arq)
    })
    .catch(error => {
      commit('setLoading', false)
      Notify.create({
        message: 'Erro ao buscar o relatório ' + relatorio + '! ' + error.response.data.message,
        color: 'negative',
        icon: 'fa fa-check-circle'
      })
    })
}
