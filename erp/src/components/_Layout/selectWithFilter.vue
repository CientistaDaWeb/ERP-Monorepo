<template>
  <q-select
    clearable
    :options="optionsList"
    v-model="model.caminhao_id"
    :label="floatLabel"
    emit-value
    map-options
    :data-vv-name="FloatLabel"
    v-validate="'required'"
    :error="errors.has(floatLabel)"
    :error-message="errors.first(floatLabel)"
  />
</template>

<script>
import {
  QSelect
} from 'quasar'

export default {
  components: {
    QSelect
  },
  props: ['optionsList', 'floatLabel'],
  name: 'LaytousSelectWithFilter',
  data: () => ({}),
  methods: {
  },
  computed: {
  },
  mounted () {
  }
}
</script>

<style>
</style>
