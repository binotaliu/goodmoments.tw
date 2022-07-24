# 管理界面的前端

`goodmoment.tw` 在後台的部分使用了 `Inertia.js` 搭配 `Vue.js 3` 來開發。  
開發時，請參考下列資源：

 - [Inertia.js](https://inertiajs.com/)
 - [Vue.js](https://vuejs.org/)
 - [Vite](https://vitejs.dev/)

## Vue 頁面的限制

Vue.js 頁面都存放在 [`resources/pages/`](../resources/pages) 目錄下，在 Laravel 中使用 `Inertia::render('Auth/Login')` 即代表要 Render `resources/pages/Auth/Login.vue`。  
由於 [Dynamic Import 的限制](https://github.com/rollup/plugins/tree/985cf4c422896ac2b21279f0f99db9d281ef73c2/packages/dynamic-import-vars#how-it-works)，這個路徑必須是一層目錄 + 一個 Vue 檔名的架構，即，只能是 `resources/pages/*/*.vue`。

## Components

可用的 Components 可以在 [`resources/components/`](../resources/components) 目錄下找到。  
Component 都冠以 `GM` (**G**ood**M**oment) 作為 Prefix。在 [`resources/components/index.js`](../resources/components/index.js) 作為 Vue Plugin 宣告，並 Export 給 [`resources/js/admin.js`](../resources/js/admin.js) 使用。
