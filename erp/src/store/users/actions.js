import User from 'src/services/user.service'
import hosApi from '../../utils/api'

export const getCurrentUser = async ({
  commit,
  context
}, payload) => {
  if (context.currentUser) {
    return context.currentUser
  }
  let userPromise = User.currentUser()
  userPromise
    .then(user => {
      commit('users/setCurrentUser', user, {
        root: true
      })
    })
    .catch(error => {
      console.log('There was an error :c')
      throw error
    })
}

export const setCurrentUser = (vuex, user) => {
  const {
    commit
  } = vuex
  commit('users/setCurrentUser', user, {
    root: true
  })
}

export const destroyCurrentUser = ({
  commit,
  context
}, payload) => {
  commit('users/setCurrentUser', null, {
    root: true
  })
}

export const searchList = (context, payload) => {
  return hosApi.searchList(context, payload)
}

export const loadItem = (context, id) => {
  return hosApi.loadItem(context, id)
}

export const saveItem = (context, payload) => {
  return hosApi.saveItem(context, payload)
}

export const updateItem = (context, payload) => {
  return hosApi.updateItem(context, payload)
}

export const deleteItem = (context, id) => {
  return hosApi.deleteItem(context, id)
}
