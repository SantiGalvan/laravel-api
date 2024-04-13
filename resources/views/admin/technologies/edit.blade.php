@extends('layouts.app')

@section('title', 'Modifica Linguaggio')

@section('content')
    <section id="fix-technology">
        <div class="d-flex align-items-center justify-content-between">
            <a href="{{route('admin.technologies.index')}}" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Torna alla lista</a>
            <h1 class="my-4">Modifica Linguaggio</h1>
        </div>

        <form action="{{route('admin.technologies.update', $technology->id)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-10">
                    <div class="mb-3">
                        <label for="label" class="form-label">Nome</label>
                        <input value="{{old('label', $technology->label)}}" type="text" class="form-control @error('label') is-invalid @elseif(old('label', '')) is-valid @enderror" id="label" name="label">
                        @error('label')   
                            <div class="invalid-feedback">{{$message}}</div>
                        @else
                            <div class="form-text">
                                Inserisci il nome del linguaggio
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-2">
                    <div class="mb-3">
                        <label for="color" class="form-label">Colore</label>
                        <input value="{{old('color', $technology->color)}}" type="color" class="form-control @error('color') is-invalid @elseif(old('color', '')) is-valid @enderror" id="color" name="color">
                        @error('color')   
                            <div class="invalid-feedback">{{$message}}</div>
                        @else
                            <div class="form-text">
                                Inserisci il colore
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-3">
                        <label for="description" class="form-label">Descrizione tipo</label>
                        <textarea class="form-control @error('description') is-invalid @elseif(old('description', '')) is-valid @enderror" id="description" name="description" rows="10">{{old('description', $technology->description)}}</textarea>
                        @error('description')   
                            <div class="invalid-feedback">{{$message}}</div>
                        @else
                            <div class="form-text">
                                Inserisci una descrizione del linguaggio
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end align-items-center gap-3">
                <button type="reset" class="btn btn-lg btn-warning"><i class="fas fa-arrows-rotate me-2"></i>Reset</button>
                <button type="submit" class="btn btn-lg btn-success"><i class="fas fa-floppy-disk me-2"></i>Salva</button>
            </div>
        </form>
    </section>
@endsection

@section('scripts')
    @vite('resources/js/image_preview.js')
@endsection