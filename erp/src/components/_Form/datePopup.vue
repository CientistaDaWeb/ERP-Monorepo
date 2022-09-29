<template>
  <q-input
    v-model="selectState"
    :label="floatLabel"
    :data-vv-name="floatLabel"
    v-validate="'required'"
    :error="errors.has(floatLabel)"
    :error-message="errors.first(floatLabel)"
  >
    <template v-slot:append>
      <q-icon
        name="fa fa-calendar"
        class="cursor-pointer"
      >
        <q-popup-proxy
          ref="qData"
          transition-show="scale"
          transition-hide="scale"
        >
          <q-date
            today-btn
            mask="DD/MM/YYYY"
            v-model="selectState"
            @input="() => $refs.qData.hide()"
          />
        </q-popup-proxy>
      </q-icon>
    </template>
  </q-input>
</template>
<script>
import moment from 'moment'
import {
  date,
  QInput,
  QDate,
  QPopupProxy
} from 'quasar'
export default {
  components: {
    QInput,
    QDate,
    QPopupProxy
  },
  props: {
    floatLabel: {
      type: String,
      required: true
    },
    model: {
      type: String
    }
  },
  name: 'FormDatePopup',
  computed: {
    selectState: {
      get () {
        return this.formatDate(this.model)
      },
      set (val) {
        this.$emit('resetModel', val)
      }
    }
  },
  methods: {
    formatDate (data) {
      if (data && data.includes('-')) {
        return date.formatDate(moment(data), 'DD/MM/YYYY')
      }
      return data
    }
  },
  mounted () {
    this.$emit('resetModel', this.formatDate(this.model))
  }
}
</script>
