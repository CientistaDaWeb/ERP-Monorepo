<template>
  <q-layout
    view="lHh Lpr lFf"
  >
    <Loader />
    <q-header>
      <q-toolbar
        class="bg-primary text-white"
        :inverted="$q.theme === 'ios'"
      >
        <q-btn
          flat
          dense
          round
          @click="leftDrawerOpen = !leftDrawerOpen"
          aria-label="Menu"
        >
          <q-icon name="fa fa-bars" />
        </q-btn>
        <q-toolbar-title>
          <img
            src="~assets/logo.png"
            style="max-height: 15px"
            class="responsive"
          >
          Acquasana ERP
          <div slot="subtitle">
            v0.1.0
          </div>
        </q-toolbar-title>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      content-class="bg-primary text-white"
      class="print-hide"
    >
      <q-card
        class="
      bg-primary
      text-white"
      >
        <q-card-section>
          <img
            :src="currentUser.avatar"
            class="responsive"
            style="padding: 20px 80px"
          >
        </q-card-section>
        <q-card-section>
          <div class="text-h6 text-center">
            {{ currentUser.nome }}
          </div>
        </q-card-section>
        <q-separator />
        <div class="row">
          <div class="col col-sm-7">
          <!--
            // TODO: Desenvolver o formulário corretamente
            -->
          <!--
            <q-btn
              @click="$router.push({name:'meus-dados.index'})"
              icon="fa fa-user"
              glossy
              label="Meus Dados"
              align="left"
              class="full-width"
            />
            -->
          </div>
          <div class="col col-sm-5">
            <q-btn
              v-if="currentUser"
              @click.native="logout"
              icon="fa fa-sign-out-alt"
              glossy
              color="negative"
              label="Sair"
              align="right"
              class="full-width"
            />
          </div>
        </div>
      </q-card>
      <Menu
        v-if="currentUser.id"
        :user_id="currentUser.id"
      />
    </q-drawer>
    <img
      src="~assets/logo.png"
      class="print-only"
      style="max-height: 75px"
    >
    <q-page-container>
      <transition
        id="teste"

        appear
        enter-active-class="animated slideInLeft"
        leave-active-class="animated slideOutRight"
      >
        <router-view
          :key="$route.fullPath"
        />
      </transition>
    </q-page-container>
  </q-layout>
</template>

<script>
import {
  openURL,
  QBtn,
  QIcon,
  QCard,
  QCardSection,
  QSeparator
} from 'quasar'

import Menu from '../../components/_Layout/menu'
import Loader from '../../components/Loader'

export default {
  name: 'LayoutDefault',
  components: {
    Loader,
    Menu,
    QBtn,
    QIcon,
    QCard,
    QCardSection,
    QSeparator
  },
  data () {
    return {
      leftDrawerOpen: this.$q.platform.is.desktop,
      permissions: []
    }
  },
  methods: {
    openURL,
    logout () {
      this.$oauth.logout()
      this.$router.replace({ name: 'app.login' })
    }
  },
  computed: {
    currentUser () {
      console.log()
      return this.$store.state.users.currentUser
    }
  },
  mounted () {
  }
}
</script>

<style>
@media print {

  header,
  footer {
    display:none;
  }
  body {
    overflow: auto;
    height: auto;
  }
  .scroll-y {
     height: auto;
     overflow: visible;
  }
  #q-app:id(div) {
    color: red;
}

  .table th{
    background-color: rgb(202, 202, 202) !important;
    -webkit-print-color-adjust: exact;
    color:black;
}

  aside > div {
    display: hide !important;
    background-color: blue !important;
  }
  main {left:-300px !important;}

}
</style>
