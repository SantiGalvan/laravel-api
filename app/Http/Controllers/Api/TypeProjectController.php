<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeProjectController extends Controller
{
    public function __invoke(string $slug)
    {
        $type = Type::whereSlug($slug)->first();
        if (!$type) return response(null, 404);

        $type->load('projects.type', 'projects.technologies');
        $projects = $type->projects;

        return response()->json(['projects' => $projects, 'label' => $type->label]);
    }
}
