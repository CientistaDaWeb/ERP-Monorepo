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

export const loadListAbertos = ({ commit, state }) => {
  const module = state.module
  const url = `${process.env.DATA_URL}api/${module.url}/abertos`
  return axios
    .get(url)
    .then(({ data }) => {
      commit('setListAbertos', data)
      return data
    })
    .catch(error => {
      Notify.create({
        message: 'Erro ao buscar a lista de ' + module.plural + ' abertos! ' + error.response.data.message,
        color: 'negative',
        icon: 'fa fa-check-circle'
      })
      commit('setListAbertos', [])
    })
}

export const loadListDivergencias = ({ commit, state }) => {
  const module = state.module
  const url = `${process.env.DATA_URL}api/${module.url}/divergencias`
  return axios
    .get(url)
    .then(({ data }) => {
      commit('setListDivergencias', data)
      return data
    })
    .catch(error => {
      Notify.create({
        message: 'Erro ao buscar a lista de ' + module.plural + ' divergências! ' + error.response.data.message,
        color: 'negative',
        icon: 'fa fa-check-circle'
      })
      commit('setListDivergencias', [])
    })
}
