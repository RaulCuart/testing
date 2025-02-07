<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Dam;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class DamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $dam_all = Dam::all();

    
    return response() -> json ([
        'status' => 'success',
        'message' => 'Dam data retrieved successfully',
        'data'=> $dam_all
    ],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (($request->getContentTypeFormat() != "json") | ($request->headers->get('Content-Type') != "application/json") ){
            return response()->json([
                'status' => 'Error: Bad request',
                'message' => 'Content-Type musut be application/json',
            ], 400); 
        } else {
            $dam = new Dam;
            $dam->curso = $request->curso;
            $dam->modulo = $request->modulo;
            $dam->descripcion = $request->descripcion;
            $dam->nHoras = $request->nHoras;
            
            $dam->save();
    
            return response() -> json ([
                'status' => 'success',
                'message' => 'Data added to database',
                'curso' => $request->curso,
                'modulo' =>$request->modulo,
                'descripcion' =>$request->descripcion,
                'nHoras' =>$request->nHoras,
            ],201);
        }
      
       
    }

    public function storeBodyReq(Request $request) {
   // try {
   
    //Separar el bearer token del tipo de autorizacion
    [$AuthorizationType, $bearerToken] = explode(' ', $request->header('Authorization'));
    //Si la autorización no es bearer, devuelve un json de error
    if ($AuthorizationType != 'Bearer') {
        return response ()->json([
            'status' => 'Error: Bad request',
            'message' => 'Authorization type must be bearer',
        ],400);
    }

    if (!$bearerToken) {
        return response()->json ([
            'message' => 'Token not provided',
            'status code and meaning' => '401 Unauthorized access',
            '$request->header(\'Authorization\')' => $AuthorizationType,

        ],401);
    }

    [$id_personal_access_token,$onlyToken] = explode('|',$bearerToken,2);
    $tokenInTable = PersonalAccessToken::find($id_personal_access_token);

    if (!$tokenInTable) {
        return response()->json([
            'message' => 'Token not provided'
        ],401);
    }

    $tokensMatch = hash_equals(hash('sha256',$onlyToken), $tokenInTable->token);

    if (!$tokensMatch) {
        return response()-> json([
            'status' => 'with errors',
            'message' => 'token not provided',
            'status code and meaning' => '401 unauthorized access',
            'Bearer token' => $bearerToken,
            'Token in table' => $tokenInTable->token,
            'Tokens match' => $tokensMatch,
        ],401);
    }
//Si el body no es json al enviar los datos devuelve un error
if (($request->getContentTypeFormat() != "json") || ($request->headers->get('Content-Type') != "application/json") ){
    return response()->json([
        'status' => 'Error: Bad request',
        'message' => 'Content-Type must be application/json',
    ], 400);
} else {
    
        $user = User::where('email',$request->email)->first();
        //Comprueba si la contraseña de este email es correcta
        if (! $user || ! Hash::check($request->password,$user->password))
        {
            return response() ->json([
                'message' => ['Username Or password incorrect']
            ],200);
        }
    
    }


    $dam = Dam::create([
        'curso' => $request->curso,
        'modulo' => $request->modulo,
        'descripcion' => $request->descripcion,
        'nHoras' => $request->nHoras,
    ]);
    $dam->save();
        
        return response() ->json([
            'status' => 'success',
            '$AuthorizationType' => $AuthorizationType,
            '$bearerToken' => $bearerToken,
            '$id_personal_access_token' => $id_personal_access_token,
            '$onlyToken' => $onlyToken,
            '$tokenInTable' => $tokenInTable,
            '$tokenInTable->token' => $tokenInTable->token,
            '$tokensMatch' => $tokensMatch,
        ],201);    
        
          //  } catch (Exception $e) {
          //      $e->getTrace();
          //  }
    //$currentAccessToken = $request->user()->currentAccessToken();
    
    //$bearerToken = $request->bearerToken();
    //$hashedToken = hash('sha256',$bearerToken);
    //[$id,$hashedToken] = explode('|',$bearerToken,2);
    
  //  return response()->json([
   //     'status' => 'success',
  //      'message' => 'Register created successfully',
  //      '$request->bearerToken()' => $request->bearerToken(),
        //'$id' => $id,
        //'$token' => $onlyToken,
        //'$HashedToken' => $hashedToken,
  //      '$currentAccessToken' => $currentAccessToken,
 //   ],200);
/*
    $request->all();

    return response()->json([
        'status'=> 'success',
        'message' => 'Flight Created successfully',
        '$request->all()' => $request->all(),
        '$request->collect()' => $request->collect(),
        '$request->getContent()' => $request->getContent(),
        '$request->getContentTypeFormat()' => $request->getContentTypeFormat(),
        '$request->getHost()' => $request->getHost(),
        '$request->getPort()' => $request->getPort(),
        '$request->getUri()' => $request->getUri(),
        '$request->headers->get(\Content-Type\')' => $request->headers->get('Content-Type'),
        '$request->headers->get(\Content-Length\')' => $request->headers->get('Content-Length'),
    ],201);
  */ 






}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dam = Dam::find($id);
        return response() -> json ([
            'status' => 'success',
            'message' => 'Dam data of id '. $id . ' retrieved successfully',
            'data'=> $dam
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
      //  $dam = Dam::find($id);
      //  return view('dams.edit',['dam' => $dam]);
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

        return response() -> json ([
            'status' => 'success',
            'message' => 'Data modified successfully',
            'curso' => $dams->curso,
            'modulo' =>$dams->modulo,
            'descripcion' =>$dams->descripcion,
            'nHoras' =>$dams->nHoras,
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dam = Dam::find($id);
        $dam->delete();

        return response() -> json ([
            'status' => 'success',
            'message' => 'Register deleted successfully',
        ],200);
    }
}
