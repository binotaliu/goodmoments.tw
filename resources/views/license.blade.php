<h3>{{ $name }}</h3>
<p>From {{ $type }}</p>
@foreach($licenses as $license)
<pre>
{{ $license['text'] }}
</pre>
@endforeach
