import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import vueMacros from 'unplugin-vue-define-options/vite'

import 'dotenv/config'

const fs = require('node:fs')
const path = require('node:path')

const server = (() => {
  const assetUrl = process.env.VITE_FRONT_URL || null
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
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js'
      ],
      buildDirectory: 'build/front',
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
