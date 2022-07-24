import Button from './Button.vue'
import Card from './Card.vue'
import FormField from './FormField.vue'
import Input from './Input.vue'
import Link from './Link.vue'
import LoadingText from './LoadingText.vue'
import Logo from './Logo.vue'
import TextLogo from './TextLogo.vue'

export default {
  install (Vue) {
    Vue.component('GMButton', Button);
    Vue.component('GMCard', Card)
    Vue.component('GMFormField', FormField)
    Vue.component('GMInput', Input)
    Vue.component('GMLink', Link)
    Vue.component('GMLoadingText', LoadingText)
    Vue.component('GMLogo', Logo)
    Vue.component('GMTextLogo', TextLogo)
  }
}
