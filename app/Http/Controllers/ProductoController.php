<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Carbon\Carbon;

class ProductoController extends Controller{

    public function index (){

        $datosProducto= Producto::all(); 

        return response()->json($datosProducto);
    }

public function guardar (Request $request){


    $datosProducto= new Producto;
    

if($request->hasfile('imagen')){

    $nombreArchivoOriginal=$request->file('imagen')->getClientOriginalName();
    $nuevoNombre=Carbon::now()->timestamp."_".$nombreArchivoOriginal;
    $carpetaDestino='./upload/';
    $request->file('imagen')->move($carpetaDestino, $nuevoNombre);

    $datosProducto->titulo=$request->titulo;
    $datosProducto->imagen=ltrim($carpetaDestino, '.').$nuevoNombre;
    $datosProducto->save();
}
return response()->json($nuevoNombre);
 }

public function ver($id){

    $datosProducto= new Producto;
    $datosEncontrados=$datosProducto->find($id);
    return response()->json($datosEncontrados);
}


public function eliminar($id) {

    $datosProducto=Producto::find($id);

    if($datosProducto){
        $rutaArchivo=base_path('public').$datosProducto->imagen;

        if(file_exists($rutaArchivo)){
            unlink($rutaArchivo);
        }
    $datosProducto->delete();
    }

    return response()->json("Registro Borrado");

    
}



}