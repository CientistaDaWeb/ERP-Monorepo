<template>
  <div class="login-view layout-padding">
    <q-card class="bg-white card inline-block">
      <q-card-section
        class="text-center"
      >
        <img
          src="~assets/logo.png"
          style="max-height: 100px"
          class="responsive"
        >
      </q-card-section>
      <q-card-section>
        <form @submit.prevent="authenticate">
          <q-input
            v-model="form.username"
            label="Email"
            required
            class="email"
            icon="fa fa-envelope"
            type="email"
            error-label="Informe um e-mail válido"
          />
          <q-input
            type="password"
            v-model="form.password"
            label="Password"
            required
            class="password"
            icon="fa fa-lock"
            error-label="A senha é obrigatória"
          />
          <div class="row justify-content-start items-center">
            <q-btn
              type="submit"
              big
              class="bg-primary full-width text-white"
              label="Login"
            />
          </div>
        </form>
      </q-card-section>
    </q-card>
  </div>
</template>
<script>
import {
  QInput,
  QBtn,
  QCard,
  QCardSection,
  Notify
} from 'quasar'

import { mapActions } from 'vuex'

export default {
  data: () => ({
    form: {
      username: null,
      password: null
    }
  }),
  components: {
    QInput,
    QBtn,
    QCard,
    QCardSection
  },
  methods: {
    loginError () {
      Notify.create({
        message: 'Email or password incorrect',
        icon: 'fa fa-lock',
        timeout: 2500,
        color: 'negative',
        textcolor: '#fff'
      })
    },
    async authenticate () {
      const { username, password } = this.form
      try {
        let authentication = await this.$oauth.login(username, password)
        let redirection = '/' // Default route
        if (this.$route.query.redirect && authentication) {
          redirection = this.$route.query.redirect
        }
        this.$router.replace(redirection)
      } catch (error) {
        // Error in Login
        // console.log(error)
        this.$q.notify({
          message: 'Erro ao fazer o login!', // + error.response.data.message,
          color: 'negative',
          icon: 'fa fa-check-circle'
        })
        this.loginError()
      }
    },
    ...mapActions('users', [])
  }
}
</script>
<style lang="stylus">
  .login-view
    display flex
    align-items center
    justify-content center
    height calc(100vh - 50px)
    background-color #ddd

    .email, .password
      margin-bottom 2rem

    .card
      padding 10px
      min-width 400px
      min-height 320px

      .title
        margin 0
        padding-left 1rem;
        border-left 3px solid #2546b1
        text-transform uppercase
        font-weight 500
        font-size 1.5rem
        margin-bottom 1rem
        letter-spacing 1px

    form
      max-width 420px
</style>
