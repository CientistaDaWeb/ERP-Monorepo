// import OAuth from 'src/oauth'
import Store from 'src/store'
// const auth = new OAuth()
export default async function (to, from, next) {
  try {
  // const user = auth.currentUser()
    const user = JSON.parse(localStorage.getItem('user').replace('__q_objt|', ''))
    if (user) {
      next(Store.dispatch('users/setCurrentUser', user))
    } else {
      next()
    }
  } catch (error) {
    console.log(error)
    next()
  }
}
