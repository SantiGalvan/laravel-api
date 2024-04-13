<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class TechnologyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $technologies = Technology::all();

        return view('admin.technologies.index', compact('technologies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.technologies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|unique:technologies',
            'color' => 'nullable|hex_color',
            'description' => 'nullable|string'
        ], [
            'label.required' => 'Il nome del linguaggio è obbligatorio',
            'label.unique' => 'Esiste già un linguaggio con questo nome',
            'color.hex_color' => 'Codice colore errato'
        ]);

        $data = $request->all();

        $technology = new Technology();

        $technology->fill($data);

        $technology->slug = Str::slug($data['label']);

        $technology->save();

        return to_route('admin.technologies.show', $technology->id)->with('type', 'success')->with('message', 'Linguaggio aggiunto');
    }

    /**
     * Display the specified resource.
     */
    public function show(Technology $technology)
    {
        return view('admin.technologies.show', compact('technology'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Technology $technology)
    {
        return view('admin.technologies.edit', compact('technology'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Technology $technology)
    {
        $request->validate([
            'label' => ['required', 'string', Rule::unique('technologies')->ignore('technology_id')],
            'color' => 'nullable|hex_color',
            'description' => 'nullable|string'
        ], [
            'label.required' => 'Il nome del tipo è obbligatorio',
            'label.unique' => 'Esiste già un tipo con questo nome',
            'color.hex_color' => 'Codice colore errato'
        ]);

        $data = $request->all();

        $technology->slug = Str::slug($data['label']);

        $technology->update($data);

        return to_route('admin.technologies.show', $technology->id)->with('type', 'success')->with('message', 'Linguaggio modificato');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Technology $technology)
    {
        $technology->delete();

        return to_route('admin.technologies.index')->with('type', 'danger')->with('message', "Linguaggio: $technology->label eliminato con successo");
    }

    // Trash
    public function trash()
    {
        $technologies = Technology::onlyTrashed()->get();
        return view('admin.technologies.trash', compact('technologies'));
    }

    public function restore(string $id)
    {
        $technology = Technology::onlyTrashed()->findOrFail($id);
        $technology->restore();

        return to_route('admin.technologies.index')->with('type', 'success')->with('message', "Linguaggio: $technology->label ripristinato con successo");
    }

    public function drop(string $id)
    {
        $technology = Technology::onlyTrashed()->findOrFail($id);
        $technology->forceDelete();

        return to_route('admin.technologies.trash')->with('type', 'danger')->with('message', "Linguaggio: $technology->label eliminato definitivamente");
    }
}
