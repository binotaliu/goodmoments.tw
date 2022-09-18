<?php

return [

    /*
|--------------------------------------------------------------------------
| Validation Language Lines
|--------------------------------------------------------------------------
|
| The following language lines contain the default error messages used by
| the validator class. Some of these rules have multiple versions such
| as the size rules. Feel free to tweak each of these messages here.
|
*/

    'accepted' => '必須接受「:attribute」。',
    'accepted_if' => '當「:other」為「:value」時，應同意「:attribute」。',
    'active_url' => '「:attribute」不是有效的網址。',
    'after' => '「:attribute」應晚於「:date」。',
    'after_or_equal' => '「:attribute」應為「:date」或更晚。',
    'alpha' => '「:attribute」只能以字母組成。',
    'alpha_dash' => '「:attribute」只能以字母、數字、連接線 (-) 與底線 (_) 組成。',
    'alpha_num' => '「:attribute」只能以字母與數字組成。',
    'array' => '「:attribute」應為陣列。',
    'before' => '「:attribute」應早於「:date」。',
    'before_or_equal' => '「:attribute」應為「:date」或更早。',
    'between' => [
        'array' => '「:attribute」: 應有:min ~ :max 個元素。',
        'file' => '「:attribute」應介於 :min 至 :max KB 之間。 ',
        'numeric' => '「:attribute」應介於 :min 至 :max 之間。',
        'string' => '「:attribute」的長度應介於 :min 至 :max 個字元之間。',
    ],
    'boolean' => '「:attribute」應為布林值。',
    'confirmed' => '「:attribute」確認欄位的輸入不一致。',
    'current_password' => '密碼不正確。',
    'date' => '「:attribute」不是有效的日期。',
    'date_equals' => '「:attribute」應等於「:date」。',
    'date_format' => '「:attribute」不符合格式「:format」。',
    'declined' => '必須拒絕「:attribute」。',
    'declined_if' => '當「:other」為「:value」時，應拒絕「:attribute」。',
    'different' => '「:attribute」不可與「:other」相同。',
    'digits' => '「:attribute」應為「:digits」位數字。',
    'digits_between' => '「:attribute」只能有「:min」至「:max」位數。',
    'dimensions' => '「:attribute」圖片尺寸不正確。',
    'distinct' => '「:attribute」是重複資料。',
    'email' => '「:attribute」應為有效的 E-mail。',
    'ends_with' => '「:attribute」結尾應包含下列之一：:values。',
    'enum' => '所選的「:attribute」無效。',
    'exists' => '「:attribute」不存在。',
    'file' => '「:attribute」應為有效的檔案。',
    'filled' => '「:attribute」不能留空。',
    'gt' => [
        'array' => '「:attribute」至少要有超過 :value 個項目。',
        'file' => '「:attribute」應大於 :valueKB。',
        'numeric' => '「:attribute」應大於 :value。',
        'string' => '「:attribute」至少要超過 :value 個字元。',
    ],
    'gte' => [
        'array' => '「:attribute」至少要有 :value 個項目。',
        'file' => '「:attribute」至少要有 :valueKB。',
        'numeric' => '「:attribute」應大於或等於 :value。',
        'string' => '「:attribute」至少要有 :value 個字元。',
    ],
    'image' => '「:attribute」應為圖片。',
    'in' => '所選擇的「:attribute」選項無效。',
    'in_array' => '「:attribute」未包含於「:other」。',
    'integer' => '「:attribute」應為整數。',
    'ip' => '「:attribute」應為有效的 IP 位址。',
    'ipv4' => '「:attribute」應為有效的 IPv4 位址。',
    'ipv6' => '「:attribute」應為有效的 IPv6 位址。',
    'json' => '「:attribute」應為正確的 JSON 字串。',
    'lt' => [
        'array' => '「:attribute」應少於 :value 個項目。',
        'file' => '「:attribute」應小於 :valueKB。',
        'numeric' => '「:attribute」應小於 :value。',
        'string' => '「:attribute」應少於 :value 個字元。',
    ],
    'lte' => [
        'array' => '「:attribute」不可有超過 :value 個項目。',
        'file' => '「:attribute」不可大於 :valueKB。',
        'numeric' => '「:attribute」不可大於 :value。',
        'string' => '「:attribute」不可超過 :value 個字元。',
    ],
    'mac_address' => '「:attribute」必須為有效的 MAC 位址。',
    'max' => [
        'array' => '「:attribute」不可有超過 :max 個項目。',
        'file' => '「:attribute」不可大於 :maxKB。',
        'numeric' => '「:attribute」不可大於 :max。',
        'string' => '「:attribute」不可超過 :max 個字元。',
    ],
    'mimes' => '「:attribute」應為「:values」格式的檔案。',
    'mimetypes' => '「:attribute」應為「:values」格式的檔案。',
    'min' => [
        'array' => '「:attribute」至少要有 :min 個項目。',
        'file' => '「:attribute」至少要有 :minKB。',
        'numeric' => '「:attribute」應大於或等於 :min。',
        'string' => '「:attribute」至少要有 :min 個字元。',
    ],
    'multiple_of' => '「:attribute」應從「:value」中選擇多個項目。',
    'not_in' => '所選擇的「:attribute」選項無效。',
    'not_regex' => '「:attribute」的格式錯誤。',
    'numeric' => '「:attribute」應為數字。',
    'password' => [
        'letters' => '「:attribute」必須包含至少一個英文字母。',
        'mixed' => '「:attribute」必須包含至少一個大寫字母與一個小寫字母。',
        'numbers' => '「:attribute」必須包含至少一個數字。',
        'symbols' => '「:attribute」必須包含至少一個特殊符號。',
        'uncompromised' => '輸入的 :attribute 有在資料外洩 (Data Leak) 中出現，請選擇一個不同的 :attribute。',
    ],
    'present' => '應有「:attribute」欄位。',
    'prohibited' => '禁止「:attribute」欄位。',
    'prohibited_if' => '當 :other 為 :value 時，禁止「:attribute」欄位。',
    'prohibited_unless' => '除非 :other 為 :value 時，否則禁止「:attribute」欄位。',
    'prohibits' => '「:attribute」欄位禁止出現「:other」。',
    'regex' => '「:attribute」的格式錯誤。',
    'required' => '「:attribute」不能留空。',
    'required_array_keys' => '「:attribute」欄位必須包含「:values」屬性。',
    'required_if' => '當「:other」為「:value」時，「:attribute」不能留空。',
    'required_unless' => '當「:other」不是「:values」，時「:attribute」不能留空。',
    'required_with' => '當有「:values」時，「:attribute」不能留空。',
    'required_with_all' => '當有「:values」時，「:attribute」不能為空。',
    'required_without' => '當沒有「:values」時，「:attribute」不能留空。',
    'required_without_all' => '當沒有「:values」時，「:attribute」不能留空。',
    'same' => '「:attribute」與「:other」應相同。',
    'size' => [
        'array' => '「:attribute」應有 :size 個項目。',
        'file' => '「:attribute」應為 :sizeKB。',
        'numeric' => '「:attribute」應為 :size。',
        'string' => '「:attribute」應有 :size 個字元。',
    ],
    'starts_with' => '「:attribute」應以下列值開頭：「:values」。',
    'string' => '「:attribute」應為一個字串。',
    'timezone' => '「:attribute」應為有效的時區。',
    'unique' => '「:attribute」已被使用。',
    'uploaded' => '「:attribute」上傳失敗。',
    'url' => '「:attribute」格式錯誤。',
    'uuid' => '「:attribute」應為有效的 UUID。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
