@extends('master')

@section('title', 'Vue.js App')

@section('content')

<h2>Parabéns {{$name}}</h2>
<p>O seu email {{$email}} foi validado com sucesso, a sua password de acesso temporário é "{{$password}}"</p>

@endsection
