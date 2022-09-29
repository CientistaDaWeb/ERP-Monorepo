<template>
  <div>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        :label="module.plural"
        :icon="module.icon"
      />
      <q-breadcrumbs-el label="Lista" />
    </q-breadcrumbs>
    <br>
  </div>
</template>

<script>
export default {
  name: 'LayoutBreadcrumbList',
  props: {
    module: {
      type: Object,
      required: true
    }
  }
}
</script>

<style>
</style>
