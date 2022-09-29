<template>
  <transition
    enter-active-class="animated bounceInLeft"
    leave-active-class="animated bounceOutRight"
    appear
  >
    <q-banner
      class="q-mb-sm bg-negative text-white"
    >
      <template v-slot:avatar>
        <q-icon
          name="fa fa-exclamation-triangle"
          color="white"
          style="font-size: 1.25rem"
        />
      </template>
      Nenhum dado encontrado!
    </q-banner>
  </transition>
</template>

<script>
import {
  QIcon,
  QBanner
} from 'quasar'

export default {
  name: 'AlertEmptyContent',
  components: {
    QIcon,
    QBanner
  }
}
</script>

<style>
</style>
