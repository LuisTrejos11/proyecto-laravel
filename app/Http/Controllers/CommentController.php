<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function save(Request $request){

        // validar 
        $validate = $this->validate($request, [
            'image_id' => 'required|integer',

            'content' => 'required|string'
        ]);
            // recoger datos
        $user = \Auth::user();
        $image_id= $request->input('image_id');
        $content= $request->input('content');

        //asigno los valores a mi nuevo objeto
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;
            // guaradar en la base de datos
        $comment->save();

        return redirect()->route('image.detail', ['id' => $image_id])
                        ->with(['message'=> 'Has publicado tu comentario correctamente']);



        
    }

    public function delete($id){
        //conseguir datos de usuario identificado 
        $user= \Auth::user();

        //conseguir objeto del comentario 
        $comment = Comment::find($id);

        //comprobar si soy el dueño del comentario o la publicacion 
        if($user && ($comment->user_id == $user->id || $comment->image->user_id == $user->id )){
              $comment->delete();

              return redirect()->route('image.detail', ['id' =>$comment->image->id])
                        ->with(['message'=> 'Se ha eliminado tu comentario correctamente']);
        }else{
            return redirect()->route('image.detail', ['id' =>$comment->image->id])
                        ->with(['message'=> ' No se ha eliminado tu comentario ']);
        }

    }
}
