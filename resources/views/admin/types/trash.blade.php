@extends('layouts.app')

@section('title', 'Cestino Tipi')

@section('content')
    <section id="trash-types">
      <div class="d-flex align-items-center justify-content-between">

        <a href="{{route('admin.types.index')}}" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Torna alla lista</a>

        <h1 class="my-4">Tipi eliminati</h1>

        <a href="" class="btn btn-danger"><i class="fas fa-trash me-2"></i>Svuota cestino</a>

      </div>

      <table class="table table-dark">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">Colore</th>
            <th scope="col">Creato il</th>
            <th scope="col">Ultima modifica</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody class="table-group-divider">
            @forelse ($types as $type)
            <tr>
                <th scope="row">{{$type->id}}</th>
                <td>{{$type->label}}</td>
                <td>{{$type->color}}</td>
                <td>{{$type->created_at}}</td>
                <td>{{$type->updated_at}}</td>
                <td>
                    <div class="d-flex justify-content-end align-items-center gap-2">
                        <a href="{{route('admin.types.show', $type->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                        <a href="{{route('admin.types.edit', $type->id)}}" class="btn btn-sm btn-warning"><i class="fas fa-pencil"></i></a>
                        <form action="{{route('admin.types.restore', $type->id)}}" method="POST" class="restore-form">
                          @csrf
                          @method('PATCH')
                          <button class="btn btn-sm btn-success"><i class="fas fa-arrows-rotate"></i></button>
                      </form>
                        <form action="{{route('admin.types.drop', $type->id)}}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash-can"></i></button>
                        </form>
                    </div>
                </td>
              </tr>
            @empty
              <tr>
                <th colspan="6">
                    <h3>Al momento non ci sono tipi</h3>
                </th>
            </tr>  
            @endforelse
        </tbody>
      </table>
          
    </section>
@endsection

@section('scripts')
  @vite('resources/js/delete_confirmation.js')
@endsection