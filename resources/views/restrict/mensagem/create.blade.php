@extends('restrict.layout')

@section('content')
@if(count($errors) > 0)
<ul class="validator">
    @foreach($errors->all() as $error)
    <li>{{$error}}</li>
    @endforeach
</ul>
@endif
<form method="POST" action="{{url('mensagem')}}" enctype="multipart/form-data">
    @csrf
    @method('POST')
    <div>
        <label for="titulo">Título</label>
        <input type="text" name="titulo" id = "titulo" value="{{old('titulo') }}" required/>
    </div>
    <div>
        <label for="msg">Mensagem</label>
        <textarea name="mensagem" id="msg" required>{{old('mensagem')}} </textarea>
    </div>
    <div>
        <label>
            Tópicos
            <a href="{{url('topico/create')}}" class="button">Novo Tópico</a>
        </label>
        <div class="sub">
            @foreach($topicos as $topico)
            <input type="checkbox" id="top{{$topico->id}}" value="{{$topico->id}}" name="topico[]" @if($topico->id==old('topico_id')) checked @endif />
            <label for="top{{$topico->id}}">{{$topico->topico}}</label>
            @endforeach
        </div>
    </div>
    <div>
        <label for="img">Imagem</label>
        <input type="file" name="imagem" id="img" accept="image/*" required/>
    </div>
    <button type="submit" class="button">Salvar</button>
</form>
@endsection