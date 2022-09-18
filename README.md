<h1 align="center">🌄 <code>goodmoments.tw</code></h1>

----

![BUILT WITH LOVE](https://forthebadge.com/images/badges/built-with-love.svg)

[![PHP 8.1](https://img.shields.io/badge/PHP-8.1-8892BF?logo=php)](https://php.net/) [![Laravel 9](https://img.shields.io/badge/Laravel-9-FF2D20?logo=laravel)](https://laravel.com/) [![Vue.js 3](https://img.shields.io/badge/Vue.js%20-3-4fc08d?logo=vue.js)](https://vuejs.org) [![Inertia.js](https://img.shields.io/badge/Made%20with-Inertia.js-6B45C1)](https://inertiajs.com/)

`goodmoments.tw` is a branding website made for "好時・左鎮公舘."  The brand is run by a Taiwanese community development association, "左鎮公舘 (Zuojheng Gongguan)."  
`goodmoments.tw` 是「好時・左鎮公舘」的品牌網站。「好時・左鎮公舘」是由「台南市左鎮區公舘社區發展協會」經營的品牌。

## Installation - 安裝

Install dependencies:  
安裝相依性套件：  
```
$ composer install
$ npm ci
```

Copy and edit `.env`:  
複製並編輯 `.env`：  
```
$ php -r "file_exists('.env') || copy('.env.example', '.env');"
$ vim .env
```

Install application:  
安裝專案程式：
```
$ php artisan key:generate
$ php artisan migrate # or migrate:fresh to re-install
$ php artisan install
$ php artisan db:seed
```

Compile frontend assets:  
編譯前端素材：  
```
$ npm run dev
```

If you want to run the vite server with https enabled, please set `VITE_HTTPS_CERT` and `VITE_HTTPS_KEY` in .env with your https certification, and configure a proper `ASSET_URL`. For example:  
若要在有啟用 HTTPS 的情況下執行 Vite Server，請在 `.env` 中將 `VITE_HTTPS_CERT` 和 `VITE_HTTPS_KEY` 設定為你使用的 HTTPS 憑證，並設定適當的 `ASSET_URL`。例如：  
```
ASSET_URL=https://goodmoment.tw.test:5173

VITE_HTTPS_KEY=/Users/user/.config/valet/Certificates/goodmoment.tw.test.key
VITE_HTTPS_CERT=/Users/user/.config/valet/Certificates/goodmoment.tw.test.crt
```

## Deployment - 部署

To run the website, you must set up following software on the host:  
若要執行該網站，必須在主機上設定下列程式：

- PHP 8.1
- MySQL 8

Most of the configuration files can be found inside `etc` folder of this repository, along with the systemd unit files.  
大多數設定檔都可在本專案的 `etc` 資料夾下找到，該資料夾內也有一些 systemd Unit 檔。  

## Tests - 測試

### Unit Test / Feature Test
``` 
$ php artisan test
```

## Features - 功能

<!-- @TODO: list features -->

## License - 授權條款

All codes except for image assets contained in this repository are licensed under the [`AGPL-3.0-or-later`](LICENSE).  
  
Please notice that image assets including but not limited to [`resources/images/logo.svg`](resources/images/logo.svg), [`resources/images/text-logo.svg`](resources/images/text-logo.svg), and [`resources/components/Logo.svg`](resources/components/Logo.vue) are copyrighted by "台南市左鎮區公舘社區發展協會", thus not covered by AGPL license. Please contact the organization for further information. **You are not allowed to use or redistribute these files without permission.**  

In the future releases I will remove these files from the repository to avoid unnecessary confusion.

本專案中，除了圖片素材外，所有程式碼都適用於 [`AGPL-3.0-or-later`](LICENSE) 授權條款。  

請注意，圖片素材，包括但不限於 [`resources/images/logo.svg`](resources/images/logo.svg)、[`resources/images/text-logo.svg`](resources/images/text-logo.svg)、[`resources/components/Logo.svg`](resources/components/Logo.vue) 等，皆為「台南市左鎮區公舘社區發展協會」版權所有，並非 AGPL 授權條款的一部分。請聯絡該組織以取得更多資訊。**在未經授權的情況下，不可任意使用或重新分發 (Redistribute) 這些檔案。**

在未來的版本中，我會把這些檔案從 Repository 中刪除，以避免不必要的誤會。
