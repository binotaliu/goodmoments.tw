import vue from '@vitejs/plugin-vue'

import 'dotenv/config'
import laravel from 'laravel-vite-plugin'
import vueMacros from 'unplugin-vue-define-options/vite'
import { defineConfig } from 'vite'

const fs = require('node:fs')
const path = require('node:path')

const server = (() => {
  const assetUrl = process.env.VITE_ADMIN_URL || null
  if (assetUrl === null) {
    return null
  }

  const server = {}
  const parsedUrl = new URL(assetUrl)
  if (parsedUrl.protocol === 'https:' && process.env.VITE_HTTPS_CERT && process.env.VITE_HTTPS_KEY) {
    server.https = {
      cert: fs.readFileSync(process.env.VITE_HTTPS_CERT),
      key: fs.readFileSync(process.env.VITE_HTTPS_KEY),
    }
  } else {
    server.https = parsedUrl.protocol === 'https:'
  }
  server.port = parsedUrl.port || (server.https ? 443 : 80)
  server.host = parsedUrl.hostname

  return server
})()

export default defineConfig({
  resolve: {
    alias: {
      '@': path.resolve(__dirname, './resources'),
    }
  },

  ...(server === null ? {} : { server }),

  build: {
    rollupOptions: {
      manualChunks(id) {
        const chunksMap = {
          'node_modules/@heroicons': 'vendor-icons',
          'node_modules': 'vendors',
          'resources/components': 'components',
          'resources/js': 'utils',
          'resources/layouts/Auth': 'auth',
          'resources/pages/Articles': 'campaign',
          'resources/pages/Auth': 'auth',
          'resources/pages/Banners': 'campaign',
          'resources/pages/Categories': 'catalog',
          'resources/pages/Products': 'catalog',
          'resources/pages/Users': 'users',
          'resources/pages': 'misc',
          'resources/': 'misc',
        }

        return (
          Object
            .entries(chunksMap)
            .find(([pattern]) => id.includes(pattern)) || []
        )
          .slice(1)
          .find(() => true)
      }
    }
  },

  plugins: [
    laravel({
      input: [
        'resources/css/admin.css',
        'resources/js/admin.js'
      ],
      buildDirectory: 'build/admin',
      refresh: true
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: true,
        }
      }
    }),
    vueMacros()
  ]
})
