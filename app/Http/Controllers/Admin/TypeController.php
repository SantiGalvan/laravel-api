<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $types = Type::all();

        return view('admin.types.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|unique',
            'color' => 'nullable|hex_color',
            'description' => 'nullable|string'
        ], [
            'label.required' => 'Il nome del tipo è obbligatorio',
            'label.unique' => 'Esiste già un tipo con questo nome',
            'color.hex_color' => 'Codice colore errato'
        ]);

        $data = $request->all();

        $type = new Type();

        $type->fill($data);

        $type->save();

        return to_route('admin.types.show', $type->id)->with('type', 'success')->with('message', 'Tipo aggiunto');
    }

    /**
     * Display the specified resource.
     */
    public function show(Type $type)
    {
        return view('admin.types.show', compact('type'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type)
    {
        return view('admin.types.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Type $type)
    {
        $request->validate([
            'label' => ['required', 'string', Rule::unique('types')->ignore('type_id')],
            'color' => 'nullable|hex_color',
            'description' => 'nullable|string'
        ], [
            'label.required' => 'Il nome del tipo è obbligatorio',
            'label.unique' => 'Esiste già un tipo con questo nome',
            'color.hex_color' => 'Codice colore errato'
        ]);

        $data = $request->all();

        $type->update($data);

        return to_route('admin.types.show', $type->id)->with('type', 'success')->with('message', 'Tipo modificato');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type)
    {
        $type->delete();

        return to_route('admin.types.index')->with('type', 'danger')->with('message', "Tipo: $type->label eliminato con successo");
    }

    public function trash()
    {
        $types = Type::onlyTrashed()->get();
        return view('admin.types.trash', compact('types'));
    }

    public function restore(string $id)
    {
        $type = Type::onlyTrashed()->findOrFail($id);
        $type->restore();

        return to_route('admin.types.index')->with('type', 'success')->with('message', 'Tipo ripristinato con successo');
    }

    public function drop(string $id)
    {
        $type = Type::onlyTrashed()->findOrFail($id);
        $type->forceDelete();

        return to_route('admin.types.trash')->with('type', 'danger')->with('message', 'Tipo eliminato definitivamente');
    }
}
