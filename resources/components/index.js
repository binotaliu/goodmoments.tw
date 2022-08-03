import Alert from './Alert.vue'
import Button from './Button.vue'
import Card from './Card.vue'
import Checkbox from './Checkbox.vue'
import FormField from './FormField.vue'
import Input from './Input.vue'
import Link from './Link.vue'
import LinkButton from './LinkButton.vue'
import LoadingText from './LoadingText.vue'
import Logo from './Logo.vue'
import NavItem from './NavItem.vue'
import Paginator from './Paginator.vue'
import TextLogo from './TextLogo.vue'

export default {
  install (Vue) {
    Vue.component('GMAlert', Alert)
    Vue.component('GMButton', Button);
    Vue.component('GMCard', Card)
    Vue.component('GMCheckbox', Checkbox)
    Vue.component('GMFormField', FormField)
    Vue.component('GMInput', Input)
    Vue.component('GMLink', Link)
    Vue.component('GMLinkButton', LinkButton)
    Vue.component('GMLoadingText', LoadingText)
    Vue.component('GMLogo', Logo)
    Vue.component('GMNavItem', NavItem)
    Vue.component('GMPaginator', Paginator)
    Vue.component('GMTextLogo', TextLogo)
  }
}
