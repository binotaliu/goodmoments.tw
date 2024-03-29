import Alert from './Alert.vue'
import Button from './Button.vue'
import Card from './Card.vue'
import Checkbox from './Checkbox.vue'
import DateTimeInput from './DateTimeInput.vue'
import FormField from './FormField.vue'
import ImageAttachment from './ImageAttachment.vue'
import Input from './Input.vue'
import Link from './Link.vue'
import LinkButton from './LinkButton.vue'
import LoadingIcon from './LoadingIcon.vue'
import LoadingText from './LoadingText.vue'
import Logo from './Logo.vue'
import Main from './Main.vue'
import Modal from './Modal.vue'
import Navigation from './Navigation.vue'
import NavItem from './NavItem.vue'
import NavSection from './NavSection.vue'
import PageHeader from './PageHeader.vue'
import Paginator from './Paginator.vue'
import RemoveModal from './RemoveModal.vue'
import RichEditor from './RichEditor.vue'
import Textarea from './Textarea.vue'
import TextLogo from './TextLogo.vue'

export default {
  install (Vue) {
    Vue.component('GMAlert', Alert)
    Vue.component('GMButton', Button)
    Vue.component('GMCard', Card)
    Vue.component('GMCheckbox', Checkbox)
    Vue.component('GMDateTimeInput', DateTimeInput)
    Vue.component('GMFormField', FormField)
    Vue.component('GMImageAttachment', ImageAttachment)
    Vue.component('GMInput', Input)
    Vue.component('GMLink', Link)
    Vue.component('GMLinkButton', LinkButton)
    Vue.component('GMLoadingIcon', LoadingIcon)
    Vue.component('GMLoadingText', LoadingText)
    Vue.component('GMLogo', Logo)
    Vue.component('GMModal', Modal)
    Vue.component('GMMain', Main)
    Vue.component('GMNavigation', Navigation)
    Vue.component('GMNavItem', NavItem)
    Vue.component('GMNavSection', NavSection)
    Vue.component('GMPageHeader', PageHeader)
    Vue.component('GMPaginator', Paginator)
    Vue.component('GMRemoveModal', RemoveModal)
    Vue.component('GMRichEditor', RichEditor)
    Vue.component('GMTextarea', Textarea)
    Vue.component('GMTextLogo', TextLogo)
  }
}
