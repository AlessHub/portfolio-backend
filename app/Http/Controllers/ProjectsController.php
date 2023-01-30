<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;
use App\Http\Requests\SaveProjectsRequest;

class ProjectsController extends Controller
{
    public function index()
    {
        return Projects::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveProjectsRequest $request)
    {
        $projects = new Projects();

        // $request->validate([
        //     'title' => 'required',
        //     'link' => 'required',
        //     'image_path' => 'required'
        // ]);

        // $Projects->title = $request->title;
        // $Projects->link = $request->link;
        // $Projects->image_path = $request->image_path;
        // $Projects->save();

        Projects::create($request->validated());

        return $projects;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Projects $projects
     * @return \Illuminate\Http\Response
     */
    public function show(Projects $projects)
    {
        return $projects;
    }

    // public function show($id)
    // {
    //    $projects = Projects::find($id);
    //     return $projects;
    // }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $projects = Projects::find($id);

        $request->validate([
            'title' => 'required',
            'link' => 'required',
            'image_path' => 'required'
        ]);

        $projects->title = $request->title;
        $projects->link = $request->link;
        $projects->image_path = $request->image_path;

        $projects->update();
        return $projects;
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $projects = Projects::find($id);
        if(is_null($projects)){
            
            return response()->json('No se pudo realizar la peticion, el archivo ya no existe o nunca existio', 404);
        }

        $projects->delete();


        return response()->noContent();
    }
}
