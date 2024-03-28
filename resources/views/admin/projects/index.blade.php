@extends('layouts.app')

@section('title', 'Projects')

@section('content')
    <section id="table-projects">
      <div class="d-flex align-items-center justify-content-between">

        <a href="{{route('admin.projects.create')}}" class="btn btn-secondary"><i class="fas fa-plus me-2"></i>Crea Progetto</a>

        <h1 class="my-4">Progetti</h1>

        <a href="{{route('admin.projects.trash')}}" class="btn btn-danger"><i class="fas fa-trash me-2"></i>Vai al cestino</a>

      </div>

        <table class="table table-dark">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Titolo</th>
                <th scope="col">Tipo</th>
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
                    <td>
                      @if ($project->type)
                        <span class="badge" style="background-color: {{$project->type->color}}">{{$project->type->label}}</span>
                      @else
                        Nessuno
                      @endif
                    </td>
                    <td>
                      @forelse ($project->technologies as $technology)
                        <span class="badge rounded-pill" style="background-color: {{$technology->color}}">{{$technology->label}}</span>
                      @empty
                        Nessuno
                      @endforelse
                    </td>
                    <td>{{$project->framework}}</td>
                    <td>{{$project->getFormattedDate('created_at', 'd-m-Y H:i:s ')}}</td>
                    <td>{{$project->getFormattedDate('updated_at', 'd-m-Y H:i:s ')}}</td>
                    <td>
                        <div class="d-flex justify-content-end align-items-center gap-2">
                            <a href="{{route('admin.projects.show', $project->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                            <a href="{{route('admin.projects.edit', $project->id)}}" class="btn btn-sm btn-warning"><i class="fas fa-pencil"></i></a>
                            <form action="{{route('admin.projects.destroy', $project->id)}}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash-can"></i></button>
                            </form>
                        </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <th colspan="8">
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