{{date('Y-m-d H:i:s')}}
<h1></h1>
{{formhash()}}

<h1>33333</h1>

@json(['a'=>'111'])

{!md5('123')!}


@if($a==1)
<h1>1111</h1>
@else
<h2>2222</h2>
@endif


@foreach($_SERVER as $k=>$v)
<li>{{$k}}=>{{$v}}</li>
@endforeach
