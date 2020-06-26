const apiUrl = env('AUTH_URL') + 'api/'
export default {
  apiUrl,
  token_url: env('AUTH_URL') + 'oauth/token',
  current_user_url: apiUrl + 'user', // you can change it as you want
  endpoints: {
    users_url: apiUrl + 'users'
    // resource_url : api_url + 'resource'
  }
}
