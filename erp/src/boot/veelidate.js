import ptBR from 'vee-validate/dist/locale/pt_BR'
import VeeValidate, { Validator } from 'vee-validate'

export default ({
  Vue
}) => {
  Vue.use(VeeValidate)
  Validator.localize('pt_BR', ptBR)
}

/*
required
data-vv-name="fieldnametosubstitute"
v-validate="'required'"
:error="errors.has('fieldnametosubstitute')"
:error-message="errors.first('fieldnametosubstitute')"
*/
