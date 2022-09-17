<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Licenses - {{ config('app.name') }}</title>
</head>
<body>
<h1><code>goodmoments.tw</code></h1>
<p>
    This software is licensed under <code>AGPL-3.0-or-later</code>.
</p>
<pre>
{!! File::get(base_path('LICENSE')) !!}
</pre>


<h2>Acknowledgement</h2>
<p>
    This software make use of following open source projects:
</p>
{!! File::get(resource_path('licenses.html')) !!}
</body>
</html>
