export default {
  oauth: {
    grant_type: env('AUTH_GRANT_TYPE', 'password'),
    client_id: env('AUTH_CLIENT_ID', null),
    client_secret: env('AUTH_CLIENT_SECRET', null),
    scope: '*'
  },
  default_storage: env('DEFAULT_STORAGE', 'LocalStorage'), // Supported Types 'Cookies', 'Localstorage',
  oauth_type: 'Bearer'
}
