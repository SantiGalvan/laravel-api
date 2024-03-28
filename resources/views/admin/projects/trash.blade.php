@extends('layouts.app')

@section('title', 'Cestino')

@section('content')
    <section id="trash-projects">
      <div class="d-flex align-items-center justify-content-between">

        <a href="{{route('admin.projects.index')}}" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Torna alla lista</a>

        <h1 class="my-4">Progetti eliminati</h1>

        <a href="" class="btn btn-danger"><i class="fas fa-trash me-2"></i>Svuota cestino</a>

      </div>

        <table class="table table-dark">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Titolo</th>
                <th scope="col">Linguaggio</th>
                <th scope="col">Framework</th>
                <th scope="col">Creato il</th>
                <th scope="col">Ultima modifica</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody class="table-group-divider">
                @forelse ($projects as $project)
                <tr>
                    <th scope="row">{{$project->id}}</th>
                    <td>{{$project->title}}</td>
                    <td>{{$project->language}}</td>
                    <td>{{$project->framework}}</td>
                    <td>{{$project->getFormattedDate('created_at', 'd-m-Y H:i:s ')}}</td>
                    <td>{{$project->getFormattedDate('updated_at', 'd-m-Y H:i:s ')}}</td>
                    <td>
                        <div class="d-flex justify-content-end align-items-center gap-2">
                            <a href="{{route('admin.projects.show', $project->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                            <a href="{{route('admin.projects.edit', $project->id)}}" class="btn btn-sm btn-warning"><i class="fas fa-pencil"></i></a>
                            <form action="{{route('admin.projects.restore', $project->id)}}" method="POST" class="restore-form">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm btn-success"><i class="fas fa-arrows-rotate"></i></button>
                            </form>
                            <form action="{{route('admin.projects.drop', $project->id)}}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash-can"></i></button>
                            </form>
                        </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <th colspan="7">
                        <h3>Al momento non ci sono progetti</h3>
                    </th>
                </tr>  
                @endforelse
            </tbody>
          </table>

          <!-- Pagination -->
          @if($projects->hasPages())
            {{$projects->links()}}
          @endif
          
    </section>
@endsection

@section('scripts')
  @vite('resources/js/delete_confirmation.js')
@endsection