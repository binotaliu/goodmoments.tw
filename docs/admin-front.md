# 管理界面的前端

`goodmoments.tw` 在後台的部分使用了 `Inertia.js` 搭配 `Vue.js 3` 來開發。  
開發時，請參考下列資源：

- [Bundling Assets (Vite) – Laravel Documentation](http://laravel.com/docs/9.x/vite)
 - [Inertia.js](https://inertiajs.com/)
 - [Vue.js](https://vuejs.org/)
 - [Vite](https://vitejs.dev/)

## Vue 頁面的限制

Vue.js 頁面都存放在 [`resources/pages/`](../resources/pages) 目錄下，在 Laravel 中使用 `Inertia::render('Auth/Login')` 即代表要 Render `resources/pages/Auth/Login.vue`。  

## Components

可用的 Components 可以在 [`resources/components/`](../resources/components) 目錄下找到。  
Component 都冠以 `GM` (**G**ood**M**oments) 作為 Prefix。在 [`resources/components/index.js`](../resources/components/index.js) 作為 Vue Plugin 宣告，並 Export 給 [`resources/js/admin.js`](../resources/js/admin.js) 使用。
