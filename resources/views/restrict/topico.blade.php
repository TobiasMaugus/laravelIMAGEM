@extends('restrict.layout')

@section('content')
<div>
    <a href= "{{url('topico/create')}}" class="button">Adicionar</a>
</div>
<table>
    <thead>
        <tr>
            <th>Tópico</th>
            <th>Editar</th>
            <th>Remover</th>
        </tr>
    </thead>
    <tbody>
        @foreach($topicos as $topico)
        <tr>
            <td>{{$topico->topico}}</td>
            <td>
                <a href ="{{route('topico.edit', $topico->id)}}" class="button">
                    Editar
                </a>
            </td>
            <td>
                <form method ="POST" action = "{{route('topico.destroy', $topico->id)}}" onsubmit="return confirm('Tem certeza?')";>
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