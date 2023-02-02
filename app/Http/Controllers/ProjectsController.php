<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use App\Http\Requests\SaveProjectsRequest;

class ProjectsController extends Controller
{
    public function index()
    {
        return Projects::all();
    }

    public function store(SaveProjectsRequest $request)
    {
        $projects = new Projects();
        if ($request->hasFile('image_path')) {
            $file = $request->file('image_path');
            $destinationPath = 'images/featureds/';
            $fileName = time() . '-' . $file->getClientOriginalName();
            $uploadSucces = $request->file('image_path')->move($destinationPath, $fileName);
            $projects->image_path  = $destinationPath . $fileName;
        } else {
            $projects->image_path  = 'noFoto';
        }

        Projects::create($request->validated());

        return $projects;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Projects $projects
     * @return \Illuminate\Http\Response
     */
    public function show(Projects $projects, $id)
    {
        $projects = Projects::find($id);
        return $projects;
    }

    public function update(SaveProjectsRequest $request, $id)
    {
        $projects = Projects::find($id);

        $projects->update($request->validated());
        return $projects;
    }

    public function destroy($id)
    {
        $projects = Projects::find($id);
        if (is_null($projects)) {

            return response()->json('No se pudo realizar la peticion, el archivo ya no existe o nunca existio', 404);
        }

        $projects->delete();


        return response()->noContent();
    }
}
