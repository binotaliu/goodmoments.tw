import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'

import components from '../components'
import AdminLayout from '../layouts/Admin.vue'

createInertiaApp({
  resolve: (name) => {
    const [dir, file] = name.split('/')
    return import(`../pages/${dir}/${file}.vue`)
      .then((component) => {
        component.default.layout = component.default.layout || AdminLayout

        return component
      })
  },
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) })
    app.use(plugin)
    app.use(components)
    app.config.globalProperties.$route = route

    app.mount(el)
  }
})
