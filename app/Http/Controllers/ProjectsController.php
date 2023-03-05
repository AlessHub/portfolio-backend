<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use App\Http\Requests\SaveProjectsRequest;
use DateTime;

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
            $path = $request->file('image_path')->store('images/featureds', 'public');
            $projects->image_path  = $path;
        } else {
            $projects->image_path  = 'noFoto';
        }
        $projects->title = $request->title;
        $projects->link = $request->link;
        $projects->save($request->validated());
        // Projects::create no funciona porque crea archivos temporales en vez de subir el path de la foto
    
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
