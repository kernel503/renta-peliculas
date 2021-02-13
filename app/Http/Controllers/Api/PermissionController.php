<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'is_admin' => 'required',
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(["mensaje" => "Campos invalidos"], 400);
        }
        $id = $request['id'];
        $is_admin = $request['is_admin'];
        $user = User::find($id);
        $user->is_admin = $is_admin;
        $user->save();
        return response()->json(["mensaje" => "Rol " . ($is_admin ? 'administrador' : 'cliente') . ' asignado']);
    }
}
