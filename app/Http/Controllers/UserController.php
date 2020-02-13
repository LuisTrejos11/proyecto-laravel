<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\User;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function config(){
        return view('user.config');
    }

    public function update(Request $request){

       
        // Conseguir usuario identificado
        $user = \Auth::user();
        $id = $user->id;
       
        //validacion del formulario
        $validate= $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],

           'surname' => ['required', 'string', 'max:255'],

           'nick' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($id),],

           'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($id),],
            
        ]);

        //Recoger los datos del formulario
        $name= $request->input('name');
        $surname= $request->input('surname');
        $nick= $request->input('nick');
        $email= $request->input('email');

        //Asignar nuevos valores al objeto de usuario
        $user->name= $name;
        $user->surname= $surname;
        $user->nick= $nick;
        $user->email= $email;

        //subir imagen 
        $image_path= $request->file('image_path');
        if($image_path){
            //poner mombre unico
            $image_path_name= time().$image_path->getClientOriginalName();
            //Guardar en la carpeta
            Storage::disk('users')->put( $image_path_name,File::get($image_path));
            //setear el nombre de la imagen 
            $user->image_path=  $image_path_name;
        }

        //Ejecutar consultas y cambios en la base de datos 
        $user->update();

        //redirigir 

        return redirect()->route('config')
                            ->with(['message'=>'Usuario actualizado correctamente']);


       
    }

    public function getImage($filename){
        $file= Storage::disk('users')->get($filename);
        return new Response($file, 200);
    }

    public function profile($id){
        $user = User::find($id);

        return view('user.profile', [
            'user' => $user
        ]);
    }

}
