// Configuration for your app
var webpack = require('webpack')
var path = require('path')

// Get our env variables
const envparser = require('./src/config/envparser')

module.exports = function (ctx) {
  return {
    boot: [
      'oauth',
      'i18n',
      'axios',
      'veelidate',
      'vuemask',
      'filters',
      'v-money',
      'vuecurrency',
      'vuegooglemaps',
      'vcharts',
      'vuelidate'
    ],
    css: [
      'app.styl'
    ],
    extras: [
      'roboto-font',
      'fontawesome-v5'
    ],
    supportIE: false,
    build: {
      htmlFilename: 'index.html',
      distDir: 'public',
      scopeHoisting: true,
      vueRouterMode: 'history',
      env: envparser(),
      modern: true,
      // vueCompiler: true,
      // gzip: true,
      // analyze: true,
      // extractCSS: false,
      // useNotifier: false,
      extendWebpack (cfg) {
        cfg.module.rules.push({
          options: {
            quiet: true
          },
          enforce: 'pre',
          test: /\.(js|vue)$/,
          loader: 'eslint-loader',
          exclude: /(node_modules|quasar)/
        })

        cfg.resolve.alias.env = path.resolve(__dirname, 'src/config/helpers/env.js')

        cfg.plugins.push(
          new webpack.ProvidePlugin({
            'env': 'env' // this variable is our alias, it's not a string
          })
        )
      }
    },
    devServer: {
      port: 4462,
      https: true,
      headers: {
        'Access-Control-Allow-Origin': '*'
      },
      open: false, // opens browser window automatically
      historyApiFallback: true
    },
    // framework: 'all' --- includes everything; for dev only!
    framework: {
      iconSet: 'fontawesome-v5',
      components: [
        'QLayout',
        'QHeader',
        'QDate',
        'QFooter',
        'QDrawer',
        'QPageContainer',
        'QPageSticky',
        'QPageScroller',
        'QPage',
        'QToolbar',
        'QToolbarTitle',
        'QBtn',
        'QIcon',
        'QList',
        'QItem',
        'QItemSection',
        'QItemLabel',
        'QBreadcrumbs',
        'QBreadcrumbsEl'
      ],
      lang: 'pt-br',
      directives: [
        'Ripple'
      ],
      // Quasar plugins
      plugins: [
        'Notify',
        'LocalStorage',
        'SessionStorage',
        'Cookies',
        'Dialog',
        'Loading',
        'Meta'
      ],
      config: {
        loading: {
          message: 'Carregando...',
          messageColor: 'white',
          spinnerSize: 100,
          spinnerColor: 'white',
          customClass: 'bg-primary'
        },
        cordova: {
          iosStatusBarPadding: true / false, // add the dynamic top padding on iOS mobile devices
          backButtonExit: true / false // Quasar handles app exit on mobile phone back button
        }
      }
    },
    // animations: 'all' --- includes all animations
    animations: 'all',
    ssr: {
      pwa: true
    },
    pwa: {
      cacheExt: 'js,html,css,ttf,eot,otf,woff,woff2,json,svg,gif,jpg,jpeg,png,wav,ogg,webm,flac,aac,mp4,mp3',
      navigateFallback: '/index.html',
      manifest: {
        name: 'ERP Acquasana',
        short_name: 'ERP-Acquasana',
        // start_url: "/",
        description: 'ERP Acquasana',
        display: 'standalone',
        orientation: 'portrait',
        background_color: '#ffffff',
        theme_color: '#027be3',
        icons: [
          {
            'src': 'statics/icons/icon-128x128.png',
            'sizes': '128x128',
            'type': 'image/png'
          },
          {
            'src': 'statics/icons/icon-192x192.png',
            'sizes': '192x192',
            'type': 'image/png'
          },
          {
            'src': 'statics/icons/icon-256x256.png',
            'sizes': '256x256',
            'type': 'image/png'
          },
          {
            'src': 'statics/icons/icon-384x384.png',
            'sizes': '384x384',
            'type': 'image/png'
          },
          {
            'src': 'statics/icons/icon-512x512.png',
            'sizes': '512x512',
            'type': 'image/png'
          }
        ]
      }
    },
    cordova: {
      id: 'com.acquasana.erp.app'
    },
    electron: {
      extendWebpack (cfg) {
        // do something with cfg
      },
      packager: {
        // OS X / Mac App Store
        // appBundleId: '',
        // appCategoryType: '',
        // osxSign: '',
        // protocol: 'myapp://path',

        // Window only
        // win32metadata: { ... }
      },
      builder: {
        // https://www.electron.build/configuration/configuration

        // appId: 'quasar-app'
      }
    }
  }
}
