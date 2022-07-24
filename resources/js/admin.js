import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'

import components from '../components'

createInertiaApp({
  resolve: (name) => {
    const [dir, file] = name.split('/')
    return import(`../pages/${dir}/${file}.vue`)
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(components)
      .mount(el)
  }
})
