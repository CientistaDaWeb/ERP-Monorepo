import axios from 'axios'
import { Notify } from 'quasar'
import { urlEncodeSearch } from '../utils'

export default {
  searchList: ({ commit, state }, payload) => {
    let pagination = payload.pagination
    const filter = payload.filter
    commit('setFilter', filter)
    const where = urlEncodeSearch(payload.where, 'where')
    const whereHas = urlEncodeSearch(payload.whereHas, 'whereHas')
    const module = state.module
    // const orderDirection = (pagination.descending) ? 'DESC' : 'ASC'
    // const url = `${process.env.DATA_URL}api/${module.url}?page=${pagination.page}&limit=${pagination.rowsPerPage}&order=${pagination.sortBy},${orderDirection}&filter=${filter}${where}${whereHas}`
    const url = `${process.env.DATA_URL}api/${module.url}?page=${pagination.page}&limit=${pagination.rowsPerPage}&order=${pagination.sortBy}&filter=${filter}${where}${whereHas}`

    // console.log(url)
    commit('setList', [])
    return axios
      .get(url)
      .then(({ data }) => {
        pagination.rowsNumber = data.total
        commit('setList', data.data)
        commit('setLoading', false)
        return pagination
      })
      .catch(error => {
        Notify.create({
          message: 'Erro ao buscar a lista de ' + module.plural + '! ' + error.response.data.message,
          color: 'negative',
          icon: 'fa fa-check-circle'
        })
        commit('setLoading', false)
      })
  },
  loadList: ({ commit, state }, payload) => {
    const filter = payload.filter ? payload.filter : ''
    const where = urlEncodeSearch(payload.where, 'where')
    const module = state.module
    const limit = payload.limit ? payload.limit : '10000'
    const url = `${process.env.DATA_URL}api/${module.url}?limit=${limit}&filter=${filter}` + where
    commit('setList', [])
    return axios
      .get(url)
      .then(({ data }) => {
        commit('setList', data.data)
        return data
      })
      .catch(error => {
        Notify.create({
          message: 'Erro ao buscar a lista de ' + module.plural + '! ' + error.response.data.message,
          color: 'negative',
          icon: 'fa fa-check-circle'
        })
      })
  },
  loadItem: ({ commit, state }, id) => {
    const module = state.module
    const url = `${process.env.DATA_URL}api/${module.url}/${id}`
    return axios
      .get(url)
      .then(({ data }) => {
        commit('setItem', data)
        return data
      })
      .catch(error => {
        Notify.create({
          message: 'Erro ao buscar os dados: ' + error.response.data.message,
          color: 'negative',
          icon: 'fa fa-check-circle'
        })
      })
  },
  saveItem:
    ({ commit, state }, payload) => {
      const module = state.module
      const url = `${process.env.DATA_URL}api/${module.url}`
      return axios
        .post(url, payload)
        .then(({ data }) => {
          commit('setCurrentId', data.id)
          Notify.create({
            message: 'Registro ' + data.id + ' inserido!',
            color: 'positive',
            icon: 'fa fa-smile'
          })
          return data
        })
        .catch(error => {
          Notify.create({
            message: 'Erro ao salvar os dados: ' + error.response.data.message,
            color: 'negative',
            icon: 'fa fa-check-circle'
          })
        })
    },
  updateItem:
    ({ state, commit }, payload) => {
      const module = state.module
      const url = `${process.env.DATA_URL}api/${module.url}/${payload.id}`
      return axios
        .put(url, payload.data)
        .then(({ data }) => {
          commit('setCurrentId', data.id)
          Notify.create({
            message: 'Registro ' + data.id + ' atualizado!',
            color: 'positive',
            icon: 'fa fa-smile'
          })
          return data
        })
        .catch(error => {
          Notify.create({
            message: 'Erro ao atualizar os dados: ' + error.response.data.message,
            color: 'negative',
            icon: 'fa fa-check-circle'
          })
        })
    },
  deleteItem:
    ({ state, commit }, id) => {
      const module = state.module
      const url = `${process.env.DATA_URL}api/${module.url}/${id}`
      return axios
        .delete(url)
        .then(({ data }) => {
          Notify.create({
            message: 'Registro ' + data.id + ' excluído!',
            color: 'positive',
            icon: 'fa fa-smile'
          })
          return data
        })
        .catch(error => {
          Notify.create({
            message: 'Erro ao excluir o registro! ' + error.response.data.message,
            color: 'negative',
            icon: 'fa fa-check-circle'
          })
        })
    },
  clearItem:
    ({ commit }) => {
      commit('setItem', {})
    },
  clearList:
    ({ commit }) => {
      commit('setList', [])
    },
  setWhereValue:
    ({ commit }, value) => {
      commit('setWhere', value)
    },
  setWhereHasValue:
    ({ commit }, value) => {
      commit('setWhereHas', value)
    },
  setPaginationValue:
    ({ commit }, value) => {
      commit('setPagination', value)
    }
}
