import api from '../../utils/api'
import axios from 'axios'
import { Notify } from 'quasar'

export const searchList = (context, payload) => {
  return api.searchList(context, payload)
}

export const loadItem = (context, id) => {
  return api.loadItem(context, id)
}

export const loadList = (context, payload) => {
  return api.loadList(context, payload)
}

export const saveItem = (context, payload) => {
  return api.saveItem(context, payload)
}

export const updateItem = (context, payload) => {
  return api.updateItem(context, payload)
}

export const deleteItem = (context, id) => {
  return api.deleteItem(context, id)
}

export const setWhereValue = (context, value) => {
  return api.setWhereValue(context, value)
}

export const setWhereHasValue = (context, value) => {
  return api.setWhereHasValue(context, value)
}

export const setPaginationValue = (context, value) => {
  return api.setPaginationValue(context, value)
}

export const clearItem = (context) => {
  return api.clearItem(context)
}

export const clearList = (context) => {
  return api.clearListt(context)
}

export const loadListMapa = ({ commit, state }) => {
  const module = state.module
  const url = `${process.env.DATA_URL}api/${module.url}/mapa`
  return axios
    .get(url)
    .then(({ data }) => {
      commit('setListMapa', data)
      commit('setLoading', false)
      return data
    })
    .catch(error => {
      Notify.create({
        message: 'Erro ao buscar a lista de ' + module.plural + ' para o mapa! ' + error.response.data.message,
        color: 'negative',
        icon: 'fa fa-check-circle'
      })
      commit('setListMapa', [])
      commit('setLoading', false)
    })
}
