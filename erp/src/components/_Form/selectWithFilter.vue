<template>
  <q-select
    :options="optionsList"
    v-model="model"
    :label="floatLabel"
    emit-value
    map-options
    :data-vv-name="floatLabel"
    v-validate="'required'"
    :error="errors.has(floatLabel)"
    :error-message="errors.first(floatLabel)"
  >
    <template v-slot:no-option>
      <q-item>
        <q-item-section class="text-grey">
          Sem resultados
        </q-item-section>
      </q-item>
    </template>
  </q-select>
</template>

<script>
import {
  QSelect
} from 'quasar'

export default {
  components: {
    QSelect
  },
  props: {
    optionsList: {
      type: Array,
      required: true
    },
    floatLabel: {
      type: String,
      required: true
    },
    model: {
      type: Number,
      required: true
    } },
  name: 'FormSelectWithFilter',
  /*
  data: () => ({}),
  methods: {
    filterFn (val, update) {
      if (val === '') {
        update(() => {
          this.options = this.optionsList
        })
        return
      }

      update(() => {
        const needle = val.toLowerCase()
        this.options = this.optionsList.filter(v => v.toLowerCase().indexOf(needle) > -1)
      })
    }
  },
   */
  computed: {},
  mounted () {
  }
}
</script>

<style>
</style>
