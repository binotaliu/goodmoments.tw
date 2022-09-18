# 授權條款

`goodmoments.tw` 是以 `AGPL-3.0-or-later` 授權的開放原始碼軟體。  
在開發時採用了許多第三方套件。在網頁中，有一個 `/licenses` 頁面列出了這些套件與其授權條款。  
該頁面由程式產生而來，若要產生該頁面，請執行：

```bash
php artisan license:list
```

進一步解析該 Artisan Command：

1. 使用 [`licensed`](https://github.com/github/licensed) 來產生 `.licensed` 目錄。
2. 取得 `.licensed` 目錄下所有 Yaml 檔案，並使用 [`resources/views/license.blade.php`](resources/views/license.blade.php) 來轉譯各個 Yaml 檔。
3. 將所有轉譯結果寫入到 [`resources/licenses.html`](resources/licenses.html) 中。

當開啟 `/licenses` 頁面時，會轉譯 [`resources/views/licenses.blade.php`](resources/views/licenses.blade.php) 並將 [`resources/licenses.html`](resources/licenses.html) 的內容讀出。

不直接寫成 Blade 檔案是要避免 License 內容中包含惡意內容。例如若包含 `@php` ... `@endphp` 將有機會執行惡意程式碼。
