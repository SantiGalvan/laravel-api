@extends('layouts.app')

@section('title', 'Project')

@section('content')
    <section id="table-projects">
        <h1 class="text-center my-4">{{$project->title}}</h1>
        <div class="card p-4">
            <div class="row">
                <div class="col-3">
                    <img src="{{asset('storage/'. $project->image)}}" alt="{{$project->title}}" class="img-fluid mb-3">
                    <div><strong>Framework:</strong> {{$project->framework}}</div>
                    <div class="mt-2"><strong>Creato il:</strong> {{$project->created_at}}</div>
                    <div><strong>Ultima modifica:</strong> {{$project->updated_at}}</div>
                    <div><strong>Tipo:</strong>
                        @if ($project->type)
                        <span class="badge" style="background-color: {{$project->type->color}}">{{$project->type->label}}</span>
                        @else
                            Nessuno
                        @endif 
                    </div>
                    <div class="mt-4"><strong>Linguaggio: </strong>
                        @forelse ($project->technologies as $technology)
                            <span class="badge rounded-pill" style="background-color: {{$technology->color}}">{{$technology->label}}</span>
                        @empty
                            Nessuno
                        @endforelse
                    </div>
                </div>
                <div class="col">
                    <h3>{{$project->title}}</h3>
                    <p class="lead">{{$project->description}}</p>
                </div>
            </div>
            <footer class="d-flex justify-content-between align-items-center">
                <a href="{{route('guest.home')}}" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Torna indietro</a>
            </footer>
        </div>

       
    </section>
@endsection
