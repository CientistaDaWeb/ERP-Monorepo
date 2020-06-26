<template>
  <div>
    <q-breadcrumbs>
      <q-breadcrumbs-el
        :label="module.plural"
        :icon="module.icon"
      />
      <q-breadcrumbs-el>{{ module.btn.edit }}</q-breadcrumbs-el>
    </q-breadcrumbs>
    <br>
  </div>
</template>

<script>
export default {
  name: 'LayoutBreadcrumbEditar',
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
