@extends('restrict.layout')

@section('content')
<div>
    <a href="{{url('mensagem/create')}}" class="button">Adicionar</a>
</div>
<table>
    <thead>
        <tr>
            <th>Nome</th>
            <th>Título</th>
            <th>Mensagem</th>
            <th>Tópicos</th>
            <th>Imagem</th>
            <th>Editar</th>
            <th>Remover</th>
        </tr>
    <thead>
    <tbdody>
        @foreach($mensagens as $mensagem)
        <tr>
            <td>{{$mensagem->user->name}}</td>
            <td>{{$mensagem->titulo}}</td>
            <td>{{$mensagem->mensagem}}</td>
            <td> 
                @if($mensagem->topicos)
                @foreach($mensagem->topicos as $topico)
                <div>{{$topico->topico}}</div>
                @endforeach
                @endif
            </td>
            <td>
                <img src="{{$mensagem->imagem}}" alt="{{$mensagem->titulo}}" class="showImg"/>
                <!--<img src="{{Storage::url($mensagem->imagem)}}" alt="{{$mensagem->titulo}}" class="showImg">-->
            </td>
            <td>
                <a href="{{route('mensagem.edit',$mensagem->id)}}" class="button">
                    Editar
                </a>
            </td>
            <td>
                <form method="POST" action="{{route('mensagem.destroy',$mensagem->id)}}" onsubmit="return confirm('Tem certeza?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="button">
                        Remover
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection