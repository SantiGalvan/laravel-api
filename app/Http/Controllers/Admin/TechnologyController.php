<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Technology;
use Illuminate\Http\Request;

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
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Technology $technology)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Technology $technology)
    {
        //
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

        return to_route('admin.technologies.index')->with('type', 'success')->with('message', 'Linguaggio ripristinato con successo');
    }

    public function drop(string $id)
    {
        $technology = Technology::onlyTrashed()->findOrFail($id);
        $technology->forceDelete();

        return to_route('admin.technologies.trash')->with('type', 'danger')->with('message', 'Linguaggio eliminato definitivamente');
    }
}
