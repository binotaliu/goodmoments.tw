import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { createApp, h } from 'vue'
import { createInertiaApp, InertiaHead } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'
import CKEditor from '@ckeditor/ckeditor5-vue'

import components from '../components'
import AdminLayout from '../layouts/Admin.vue'

import dayjs from './dayjs'

// noinspection JSIgnoredPromiseFromCall
createInertiaApp({
  title: (title) => title ? `${title} – 管理面板 – 左鎮・好時公舘` : `管理面板 – 左鎮・好時公舘`,
  resolve: (name) =>
    resolvePageComponent(`../pages/${name}.vue`, import.meta.glob('../pages/**/*.vue'))
      .then((component) => {
        component.default.layout ||= AdminLayout

        return component
      }),
  setup ({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) })
    app.use(plugin)
    app.use(components)
    app.use(CKEditor)

    app.component('InertiaHead', InertiaHead)

    app.config.globalProperties.$route = route
    app.config.globalProperties.$dayjs = dayjs

    app.mount(el)
  }
})

InertiaProgress.init({
  color: '#9b8b6e'
})
