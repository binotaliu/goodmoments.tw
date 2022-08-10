# 附件

本專案中含有一個 [`Attachment` Model](../app/Models/Attachment.php)，該 Model 用於保存各類圖片或附件。  
舉例來說，產品 Model [`Product` Model](../app/Models/Product.php) 使用 Attachment Model 來關聯到其 `cover_image` 與 `images` 屬性。  

## 為什麼要把圖片分開到 Attachment 上保存？

以 Product Model 來舉例，在建立 Product 時，若不使用 Attachment Model，則在建立產品的同時需要同步上傳圖片。對於前端的體驗來說，這樣會讓建立產品的動作較慢。若我們可以在選擇圖片後，就立刻將其上傳，則建立產品時我們只需要將 Attachment 的資料傳過去就好。  

## Garbage Collector

上傳完 Attachment 之後，該 Attachment 有可能不被使用。以產品的例子來說，就是使用者在選擇圖片後，沒有繼續建立產品，或是又重新選擇了另一張圖。  
為了解決這種問題，我們需要有一個垃圾回收機制，檢查已經上傳一段時間，但未被使用的 Attachment，並將其刪除。  

[`RemoveOrphanAttachments`](../app/Jobs/RemoveOrphanAttachments.php) Job 會刪除這些未使用的 Attachment。該 Job 會檢查已經上傳超過 24 小時，但未被實際使用的 Attachment。在 [`Console\Kernel`](../app/Console/Kernel.php) 中會自動執行該 Job。

## 將其他 Model 關聯到 Attachment Model

`Attachment` 與其他 Model 間是 [Polymorphic Many-to-Many 關聯](https://laravel.com/docs/eloquent-relationships#many-to-many-polymorphic-relations)。  
若要在其他 Model 上建立與 Attachment 的關聯，只需要在該方法上加上 `HasAttachments` Trait 即可：

```php
use App\Models\Concerns\HasAttachments;

final class Product extends Model
{
    use HasAttachments;
}
```

`Attachment` 上有個 `meta` 屬性，在資料庫中以 JSON 形式保存，因此可用來供各個 Model 保存其特定的資訊。  
若要取得 `meta` 屬性，可像這樣存取：

```php
$product = Product::find(1);

$product->attachments->first()->meta;
```

## 前端

後台的前端提供了一個 [`GMAttachment`](../resources/components/Attachment.vue) Vue Component，可用來上傳圖片。  
該 Component 有三個 `v-model` 屬性：`modelValue`、`attachments`、`processing`，分別為圖片的 UUID、Attachment 實體、以及是否仍在上傳。  
  
若將 `multiple` 屬性設為 `true`，則 `modelValue` 為字串。否則將為 UUID 的陣列。  
`attachments` 永遠為陣列。  

## API

### **`POST`** `/api/attachments`

#### Payload
使用 `form/urlencoded`。

- `file` 屬性：要保存的檔案
- `disk` 可選屬性：要保存的 Disk。可能的值：`public`、`cover`、`image`。
- `meta` 任意的 JSON 字串，可用於保存檔案的資訊。


#### Result
`HTTP 201 Created`
```json5
{
    "uuid": "b8b0fd03-8d24-445d-b4cb-d72d25810852",
    "disk": "public",
    "path": "/b8/b0fd03/8d24445db4cbd72d25810852.jpg",
    "filename": "original filename.jpg",
    "mime": "image/jpeg",
    "size": 12345,
    "meta": {
      "type": "cover_image"
    },
    "md5": "d41d8cd98f00b204e9800998ecf8427e:ca0bc6549b37ea6fdfb7e19bfe31435d",
    "url": "http://localhost:8000/storage/b8/b0fd03/8d24445db4cbd72d25810852.jpg"
}
```

- `md5` 欄位是由檔案的 MD5 Hash 與將 `meta` 做 Json Serialization 後進行 MD5 Hash 的結果。

