<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::orderByDesc('updated_at')->orderByDesc('created_at')->paginate(10);

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $project = new Project();
        $types = Type::select('label', 'id')->get();
        $technologies = Technology::select('label', 'id')->get();

        return view('admin.projects.create', compact('project', 'types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate(
            [
                'title' => 'required|unique:projects|string|min:5|max:50',
                'framework' => 'nullable|string',
                'image' => 'nullable|image|mimes:png,jpg,jpeg',
                'description' => 'nullable|string',
                'type_id' => 'nullable|exists:types,id',
                'technologies' => 'nullable|exists:technologies,id'
            ],
            [
                'title.required' => 'Il titolo è obbligatorio',
                'title.min' => 'Il titolo non può essere più corto di :min caratteri',
                'title.max' => 'Il titolo non può essere più lungo di :max caratteri',
                'title.unique' => 'Titolo già inserito, riprova con un altro titolo',
                'image.image' => 'Il file inserito non è un\'immagine',
                'type_id.exists' => 'Tipo non valido',
                'technologies.exists' => 'Linguaggio non valido'
            ]
        );

        $data = $request->all();

        $project = new Project();

        $project->fill($data);

        if (Arr::exists($data, 'image')) {
            $extension = $data['image']->extension();

            $img_url = Storage::putFileAs('project_image', $data['image'], "$project->title.$extension");
            $project->image = $img_url;
        }

        $project->slug = Str::slug($data['title']);

        $project->save();

        if (Arr::exists($data, 'technologies')) $project->technologies()->attach($data['technologies']);

        return to_route('admin.projects.show', $project->id)->with('type', 'success')->with('message', 'Progetto aggiunto');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {

        $prev_technologies = $project->technologies->pluck('id')->toArray();

        $types = Type::select('label', 'id')->get();
        $technologies = Technology::select('label', 'id')->get();

        return view('admin.projects.edit', compact('project', 'types', 'technologies', 'prev_technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {

        $request->validate(
            [
                'title' => ['required', 'string', 'min:5', 'max:50', Rule::unique('projects')->ignore($project->id)],
                'framework' => 'nullable|string',
                'image' => 'nullable|image|mimes:png,jpg,jpeg',
                'description' => 'nullable|string',
                'type_id' => 'nullable|exists:types,id',
                'technologies' => 'nullable|exists:technologies,id'
            ],
            [
                'title.required' => 'Il titolo è obbligatorio',
                'title.min' => 'Il titolo non può essere più corto di :min caratteri',
                'title.max' => 'Il titolo non può essere più lungo di :max caratteri',
                'title.unique' => 'Titolo già inserito, riprova con un altro titolo',
                'image.image' => 'Il file inserito non è un\'immagine',
                'type_id.exists' => 'Tipo non valido',
                'technologies.exists' => 'Linguaggio non valido'
            ]
        );


        $data = $request->all();

        if (Arr::exists($data, 'image')) {

            if ($project->image) Storage::delete($project->image);

            $extension = $data['image']->extension();

            $img_url = Storage::putFileAs('project_image', $data['image'], "$project->title.$extension");
            $project->image = $img_url;
        }

        $project->update($data);

        if (Arr::exists($data, 'technologies')) $project->technologies()->sync($data['technologies']);
        elseif (!Arr::exists($data, 'technologies') && $project->has('technologies')) $project->technologies()->detach();

        return to_route('admin.projects.show', $project->id)->with('type', 'success')->with('message', 'Progetto modificato');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return to_route('admin.projects.index')->with('type', 'danger')->with('message', 'Progetto eliminato con successo');
    }

    public function trash()
    {
        $projects = Project::onlyTrashed()->paginate(10);
        return view('admin.projects.trash', compact('projects'));
    }

    public function restore(string $id)
    {
        $project = Project::onlyTrashed()->findOrFail($id);
        $project->restore();

        return to_route('admin.projects.index')->with('type', 'success')->with('message', 'Progetto ripristinato con successo');
    }

    public function drop(string $id)
    {
        $project = Project::onlyTrashed()->findOrFail($id);

        if ($project->image) Storage::delete($project->image);
        if ($project->has('technologies')) $project->technologies()->detach();

        $project->forceDelete();

        return to_route('admin.projects.trash')->with('type', 'danger')->with('message', 'Progetto eliminato definitivamente');
    }
}
