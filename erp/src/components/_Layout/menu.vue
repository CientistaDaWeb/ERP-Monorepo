<template>
  <div class="print-hide">
    <q-list
      no-border
      link
      inset-delimiter
      class="print-hide"
    >
      <q-item-label
        header
        class="text-white"
      >
        Menu
      </q-item-label>
      <q-item :to="{name:'dashboard'}">
        <q-item-section avatar>
          <q-icon
            name="fa fa-home"
            class="text-brand-3"
          />
        </q-item-section>
        <q-item-section class="text-brand-3">
          Dashboard
        </q-item-section>
      </q-item>
      <q-expansion-item
        v-for="category in modules"
        :key="category.id"
        :icon="category.icon"
        :label="category.categoria"
        group="menu"
      >
        <q-item
          v-for="menu in category.modulos"
          :key="menu.id"
          :to="{name:menu.controller}"
        >
          <q-item-section avatar>
            <q-icon :name="menu.icon" />
          </q-item-section>
          <q-item-section class="text-brand-3">
            {{ menu.titulo }}
          </q-item-section>
        </q-item>
      </q-expansion-item>
    </q-list>
  </div>
</template>

<script>
import {
  QIcon,
  QList,
  QItem,
  QItemSection,
  QItemLabel,
  QExpansionItem
} from 'quasar'

export default {
  components: {
    QIcon,
    QList,
    QItem,
    QItemSection,
    QItemLabel,
    QExpansionItem
  },
  name: 'LayoutMenu',
  data: () => ({}),
  methods: {
    getMenu () {
      this.$store.dispatch('modulos/menu', 1)
    }
  },
  computed: {
    modules () {
      return this.$store.state.modulos.menu
    }
  },
  mounted () {
    this.getMenu()
  }
}
</script>

<style>
</style>
