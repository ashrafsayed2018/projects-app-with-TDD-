<?php

namespace App\Http\Controllers;

use App\Project;
use App\RecordActivity;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    use RecordActivity;

    public function index()
    {


        // $projects = Project::all();
        $projects = auth()->user()->projects;


        return view('projects.index', compact('projects'));
    }


    public function create()
    {

        return view('projects.create');
    }

    public function store(Request $request)
    {


        // valide the request

        $attributes = $this->validateRequest();

        auth()->user()->projects()->create($attributes);

        // redirect the user to the project


        $projectId = Project::where('owner_id', auth()->user()->id)->orderBy('id', 'desc')->first()->id;

        return redirect('projects/' . $projectId);
    }

    public function edit(Project $project)
    {

        return view('projects.edit', compact('project'));
    }

    public function show(Project $project)
    {
        // check if the auth user is not the project owner

        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }

    public function update(Project $project)
    {

        $this->authorize('update', $project);

        $attributes = $this->validateRequest();

        $project->update($attributes);

        return redirect($project->path());
    }

    protected function validateRequest() {

      $attributes =  request()->validate([
            'title'       => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes'       => 'nullable'
        ]);

        return $attributes;
    }
}
