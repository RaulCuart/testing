<?php

namespace App\Http\Controllers;

use App\Models\Dam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DamControllerWebRoutes extends Controller
{
    public function getDamsFromApi()
    {
        $response = Http::get('http://api-rauljoel.test/api/dams');
        $jsonData = $response->json();
        
        $status = $jsonData['status'];
        $message = $jsonData['message'];
        $data = $jsonData['data'];
        
        $datos = [];
        foreach ($data as $dam) {
            //$datos[] = $status;
            //$datos[] = $message;
            $datos[]  = $dam;
        }

        //dd($status,$message,$data);
    
        dd($datos);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $dam_all = Dam::all();
    $dam_all = Dam::paginate(1);
    
    return view('dams.index', ['dam_all' => $dam_all]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dams.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dam = new Dam;
        $dam->curso = $request->curso;
        $dam->modulo = $request->modulo;
        $dam->descripcion = $request->descripcion;
        $dam->nHoras = $request->nHoras;
        

        $dam->save();
        return redirect()->route('dams.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dam = Dam::find($id);
        return view('dams.edit',['dam' => $dam]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dams = Dam::find($id);
        $dams->curso = $request->curso;
        $dams->modulo = $request->modulo;
        $dams->descripcion = $request->descripcion;
        $dams->nHoras = $request->nHoras;
        $dams->save();
        return redirect()->route('dams.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dam = Dam::find($id);
        $dam->delete();

        return redirect()->route('dams.index');
    }
}
