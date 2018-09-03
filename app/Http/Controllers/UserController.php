<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;

use sisVentas\User;
use Illuminate\Support\Facades\Redirect;
use sisVentas\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;

class UserController extends Controller
{
    
    public function index(Request $request){

        if($request){
            $query=trim($request->get('searchText'));
            $usuarios=DB::table('users')->where('name','LIKE','%'.$query.'%')
            ->orderBy('name','dec')
            ->paginate(7);
            return view('seguridad.usuario.index',["usuarios"=>
            $usuarios, "searchText"=>$query]);

            }
        }
        public function create(){

            return view('seguridad.usuario.create');
        }
        public function store (UserRequest $request){

            $usuario= new User;
            $usuario->name=$request->get('name');
            $usuario->email=$request->get('email');
            $usuario->password=Hash::make($request['password']);
            $usuario->save();
            return Redirect::to('seguridad/usuario');

        }
        public function edit($id){

            $usuario=User::findOrFail($id);
            return view('seguridad.usuario.edit', compact('usuario'));
        }
        public function update(UserRequest $request, $id){
            User::updateOrCreate(['id'=>$id],$request->all());
          /*   $usuario=User::findOrFail($id);           
            $usuario->name=$request->get('name');
            $usuario->email=$request->get('email');
            $usuario->password=Hash::make($request['password']);
            $usuario->update(); */
            return Redirect::to('seguridad/usuario');

        }
        public function destroy($id){

            $usaurio=DB::table('users')->where('id',$id)->delete();
            return Redirect::to('seguridad/usuario'); 
        }

    }

