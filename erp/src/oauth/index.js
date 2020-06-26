/***************************************************
 * [Quasar Cookies] http://quasar-framework.org/components/cookies.html
 * [Quasar LocalStorage] http://quasar-framework.org/components/web-storage.html
 **************************************************/

import {
  Cookies,
  LocalStorage
} from 'quasar'
import HttpService from './auth.service'
import Config from 'src/config'
import Store from 'src/store'

class OAuth {
  constructor () {
    this.storages = {
      Cookies,
      LocalStorage
    }
    this.session = this.storages[Config('auth.default_storage')]
  }

  logout () {
    this.session.remove('access_token')
    this.session.remove('refresh_token')
    Store.dispatch('users/destroyCurrentUser')
  }

  guest () {
    return !this.session.has('access_token')
  }

  isAuthenticated () {
    return this.session.has('access_token')
  }

  login (username, password) {
    let data = {
      username,
      password
    }

    // We merge grant type and client secret stored in configuration
    Object.assign(data, Config('auth.oauth'))
    return new Promise((resolve, reject) => {
      HttpService.attemptLogin(data)
        .then(response => {
          console.log(response)
          this.storeSession(response.data)
          resolve(response)
        })
        .catch(error => {
          console.log('OAUTH Authentication error: ', error)
          reject(error)
        })
    })
  }

  currentUser () {
    if (this.session) {
      if (this.session.has('access_token')) {
        if (this.session.has('user')) {
          // return this.getItem('user')
          // TODO: devolver o resultado em sessão
        }
        return new Promise((resolve, reject) => {
          HttpService.currentUser()
            .then(response => {
              this.setItem('user', response)
              resolve(response)
            })
            .catch(error => {
              if (error.response && (error.response.status === 401 || error.response.status === 429)) {
                this.logout()
              }
              reject(error)
            })
        })
      }
    }
    return new Promise(resolve => resolve(null))
  }

  getAuthHeader () {
    if (this.session.has('access_token')) {
      let accessToken = this.getItem('access_token')
      return Config('auth.oauth_type') + ' ' + accessToken
    }
    return null
  }

  getItem (key) {
    if (Config('auth.default_storage') === 'LocalStorage') {
      return this.session.getItem(key)
    }
    return this.session.get(key)
  }

  setItem (key, data) {
    this.session.set(key, data)
  }

  storeSession (data) {
    let hourInMilliSeconds = 86400
    let time = data.expires_in / hourInMilliSeconds

    if (Config('auth.default_storage') === 'LocalStorage') {
      this.session.set('access_token', data.access_token)
      this.session.set('refresh_token', data.access_token)
    } else {
      /*
       **  when the Storage is type Cookies
       **  we send the expires property given in days
       */
      this.session.set('access_token', data.access_token, {
        expires: time
      })
      /*
       ** We duplicate the time because,
       ** in theory it lasts the double of time access token duration
       */
      this.session.set('refresh_token', data.access_token, {
        expires: time * 2
      })
    }
  }
}

export default OAuth
