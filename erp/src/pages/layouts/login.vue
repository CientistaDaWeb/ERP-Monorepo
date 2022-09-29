<template>
  <q-layout view="lHh Lpr lFf">
    <q-header>
      <q-toolbar
        color="primary"
        :glossy="$q.theme === 'mat'"
        :inverted="$q.theme === 'ios'"
      >
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
    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import { openURL } from 'quasar'

export default {
  name: 'LayoutLogin',
  data () {
    return {
      leftDrawerOpen: this.$q.platform.is.desktop
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
      return this.$store.state.users.currentUser
    }
  }
}
</script>

<style>

</style>
