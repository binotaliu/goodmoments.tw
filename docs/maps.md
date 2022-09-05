# 地圖

地圖頁面 (`/maps`) 使用的是 OpenStreetMap 的資料，並且使用了 [Leaflet](https://leafletjs.com/) 來顯示地圖。  

## Tile

要正確在網頁上顯示地圖，還需要設定 Tile。我使用的 Tile (至少在開發階段) 是來自 [Thunderforest](https://www.thunderforest.com/) 的。因為 OSM 預設的 Tile 實在太不美觀，放在網頁上會顯得有太多複雜的資料。Thunderforest 的 `Atlas` 或 `Transport` 是看起來最好看的。  

要使用 Thunderforest 的 Tile，需要先註冊一個帳號並取得 API Key。以公舘社區來說，免費帳號的額度應該是夠的。除非遇到有人惡意使用我們的 API Key。  
取得 API Key 後，在 `.env` 中設定
```ini
MAP_TILELAYER="https://tile.thunderforest.com/atlas/{z}/{x}/{y}.png?apikey=<你的 API Key>"
```

將 `<你的 API Key>` 替換成 Thunderforest 提供給你的 API Key 即可。網址中的 `{z}`、`{x}`、`{y}` 是給 Leaflet 使用的 Placeholder，保留原樣寫在 `.env` 中即可。

另外，請注意 Thunderforest 的版權申明要求，必須要在地圖下方顯示 Attribution。請在 `.env` 中設定：
```ini
MAP_TILELAYER_ATTRIBUTION='Maps: &copy; <a href="http://www.thunderforest.com/">Thunderforest</a>, Data: &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap Contributors</a>'
```

## 地圖平台

為了方便使用者用自己慣用的地圖 APP 開啟地圖，在網頁上提供改了三個連結，分別是 Google 地圖、Apple 地圖、OpenStreetMap。  

在顯示上，會依據 UA 來判斷推薦使用哪個地圖平台。其他兩個連結也會顯示，只是會有限推薦其中一個平台而已。  

目前推薦的規則如下：
 - 在 iOS、iPadOS、macOS 上，優先推薦 Apple 地圖
 - 使用 Linux 但不是 Android 的使用者，推薦 OpenStreetMap
 - 其他情況，推薦 Google 地圖
