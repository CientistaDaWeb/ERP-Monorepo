<template>
  <q-layout view="lHh Lpr lFf">
    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import { openURL } from 'quasar'

export default {
  name: 'LayoutPrint',
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
