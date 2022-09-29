<template>
  <div class="row q-col-gutter-md">
    <div class="col col-xs-12">
      <div class="row q-col-gutter-md">
        <div class="col col-sm-12 col-xs-12">
          <q-uploader
            hide-upload-btn="true"
            flat
            bordered
            url="http://localhost"
            label="Localização"
            :error="errors.has('logo')"
            :error-message="errors.first('logo')"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {
  QUploader
} from 'quasar'
export default {
  name: 'OrdemServicoImagems',
  components: {
    QUploader
  }
}
</script>
