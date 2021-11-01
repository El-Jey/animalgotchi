@extends('layouts.main')

@section('content')
<div class="content">
    <div class="title m-b-md">{{ env('APP_CREATOR') }}</div>

    <div class="links">
        <a href="/animalgotchi">Animalgotchi</a>
        <a href="https://github.com/El-Jey" target="_blank">GitHub</a>
    </div>

</div>
@endsection