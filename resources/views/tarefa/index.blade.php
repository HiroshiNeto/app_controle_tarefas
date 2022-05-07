@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            Tarefas
                        </div>
                        <div class="col-6">
                            <div class="float-end">
                                <a class="me-3" href="{{route('tarefa.create')}}">Novo</a>
                                <a class="me-3" href="{{route('tarefa.exportacao', ['extensao' => 'xlsx'])}}">XLSX</a>
                                <a class="me-3" href="{{route('tarefa.exportacao', ['extensao' => 'csv'])}}">CSV</a>
                                <a class="me-3" href="{{route('tarefa.exportacao', ['extensao' => 'pdf'])}}">PDF</a>
                                <a class="me-3" href="{{route('tarefa.exportar')}}" target="_blank">PDF V2</a>
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tarefa</th>
                                <th scope="col">Data Limite Conclusao</th>
                                <th scope="col">Usuario</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tarefas as $key => $tarefa)
                            <tr>
                                <th scope="row">{{ $tarefa->id }}</th>
                                <td >{{ $tarefa->tarefa }}</td>
                                <td >{{ date('d/m/Y', strtotime($tarefa->data_limite_conclusao)) }}</td>
                                <td>{{ $tarefa->user->name }}</td>
                                <td><a class="btn btn-primary" href="{{ route('tarefa.edit', $tarefa->id) }}">Editar</a></td>
                                <td>
                                    <form id="form_{{$tarefa->id}}" method="post" action="{{ route('tarefa.destroy', ['tarefa' => $tarefa->id]) }}">
                                        @method('DELETE')
                                        @csrf
                                        <a class="btn btn-primary" onclick="document.getElementById('form_{{$tarefa->id}}').submit()" href="#">Excluir</a></td>

                                    </form>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>     
                    <nav>
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="{{ $tarefas->previousPageUrl() }}"><</a></li>
                            @for($i = 1; $i <= $tarefas->lastPage(); $i++)
                            <li class="page-item {{ $tarefas->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ $tarefas->url($i) }}">{{$i}}</a>
                            </li>
                            @endfor
                            <li class="page-item"><a class="page-link" href="{{ $tarefas->previousPageUrl() }}">></a></li>
                        </ul>
                    </nav>
                </div>
                <a href="{{ url()->previous() }}" class="btn btn-primary">Voltar</a>
            </div>
        </div>
    </div>
</div>
@endsection
