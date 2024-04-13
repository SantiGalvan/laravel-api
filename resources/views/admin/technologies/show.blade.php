@extends('layouts.app')

@section('title', 'Type')

@section('content')
    <section id="table-type">
        <h1 class="text-center my-4">{{$technology->label}}</h1>
        <div class="card p-4" style="background-color: {{$technology->color}}">
            <div class="row">
                <div class="col-3">
                    <img src="{{asset('storage/'. $technology->image)}}" alt="{{$technology->title}}" class="img-fluid mb-3">
                    <div class="mt-2"><strong>Creato il:</strong> {{$technology->created_at}}</div>
                    <div><strong>Ultima modifica:</strong> {{$technology->updated_at}}</div>
                </div>
                <div class="col">
                    <h3>{{$technology->title}}</h3>
                    <p class="lead">{{$technology->description}}</p>
                </div>
            </div>
            <footer class="d-flex justify-content-between align-items-center">
                <a href="{{route('admin.technologies.index')}}" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Torna indietro</a>
                <div class="d-flex justify-content-between gap-2 mt-4">
                    <a href="{{route('admin.technologies.edit', $technology->id)}}" class="btn btn-warning"><i class="fas fa-pencil me-2"></i>Modifica</a>
                    <form action="{{route('admin.technologies.destroy', $technology->id)}}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger"><i class="fas fa-trash-can me-2"></i>Elimina</button>
                    </form>
                </div>
            </footer>
        </div>

       
    </section>
@endsection

@section('scripts')
  @vite('resources/js/delete_confirmation.js')
@endsection