<?php
namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class AccountController extends Controller{


    protected function jwt(Account $account){
        $payload = [
            'iss' => "",
            "sub" => $account->id,
            "iat" => time(),
        ];

        return JWT::encode($payload, env('JWT_SECRET'));
    }
    /*Función para obtener todos los usuarios*/
    public function getAll(Request $request){
        $accounts = Account::all()->fresh('state', 'workpoint', 'rol', 'modules', 'permissions');
        $accounts = $accounts->map( function ($account){
            return $account = $this->customAccount($account);
        });
        return response()->json($accounts);
    }

    public function getProfile(Request $request){
        $acc = Account::find($request->id);
        if(!$acc){
            return response()->json([
                'msg' => 'El usuario no existe',
                'status' => 404
            ]);
        }
        $acc = $this->customAccount($acc);
        
        $validation = $this->checkHierarchy($request->auth, $acc);
        if(!$validation){
            return response()->json([
                'msg' => 'El usuario no tiene los permisos para afectar la cuenta',
                'status' => 201
            ]);
        }
        return response()->json($acc);
    }

    public function delete(Request $request){
        $account = Account::find($request->id);
        if(!$account){
            return response()->json([
                'msg' => 'El usuario no existe',
                'status' => 404
            ]);
        }
        $res = $account->delete();
        if($res){
            return response()->json([
                'msg' => 'Cuenta eliminada correctamente',
                'status' => 200
            ]);
        }
        return response()->json([
            'msg' => 'No se ha podido eliminar la cuenta',
            'status' => 200
        ]);
    }


    //public function update

    /**
     * Función para creación de usuarios
     */

    public function new(Request $request){
        $message = [
            'required' => 'Este campo es necesario',
            'nick.unique' => 'El nickname ya ha sido registrado',
            '_current_workpoint.exists' => 'El punto de trabajo no existe'
        ];
        $this->validate($request, [
            'nick' => 'required|unique:accounts,nick',
            'names' => 'required',
            'surname_pat' => 'required',
            'surname_mat' => 'required',
            '_current_workpoint'=> 'required|exists:workpoints,id',
            'auth' => 'required'
        ], $message);
         /**
          * FALTA AGREGAR ROL
          */
        $id = DB::table('accounts')->insertGetId([
            'nick' => $request->nick,
            'password' => ($request->password ? Hash::make($request->password) : Hash::make('12345')),
            'picture' => null,
            'names' => $request->names,
            'surname_pat' => $request->surname_pat,
            'surname_mat' => $request->surname_mat,
            '_current_workpoint' => $request->_current_workpoint,
            '_rol' => $request->_rol,
            '_state' => 1,
        ]);
         if($id){
             /**
              * Asignación de permisos
              */
            $log = DB::table('account_logs')->insert([
                '_log_type' => 1,
                '_accfrom' => $request->auth->id,
                'accto' => $id
            ]);
         }else{
            return response()->json([
                'msg' => 'No se ha podido crear la cuenta',
                'err' => 201
            ]);
        }
    }

     /**
      * Función de actualización de usuarios
      */
    public function edit(Request $request){
        $account = Account::find($request->id);
        if(!$account){
            return response()->json([
                'msg' => 'No se ha encontrado la cuenta',
                'status' => 404
            ]);
        }
        $validations = [
            'names' => 'required',
            'surname_pat' => 'required',
            'surname_mat' => 'required',
            'auth' => 'required',
            'nick' => null,
            '_current_workpoint'=> null,
            '_state' => null
        ];
        if(strtoupper($request->nick) != strtoupper($account->nick)){
            $validations->nick = 'required|unique:accounts,nick';
        }else{
            $validations->nick = 'required';
        }
        
        if($request->_state != $account->_state){
            $validations->_state = 'required|exists:accounts_states,id';
        }else{
            $validations->_state = 'required';
        }

        if($request->_current_workpoint != $account->_curret_workpoint){
            $validations->_current_workpoint = 'required|exists:workpoints,id';
        }else{
            $validations->_current_workpoint = 'required';
        }

        $message = [
            'required' => 'Este campo es necesario',
            'nick.unique' => 'El nickname ya ha sido registrado',
            '_current_workpoint.exists' => 'El punto de trabajo no existe'
        ];
        $this->validate($request, $validations, $message);

        $result = DB::table('accounts')
                ->where('id', $request->id)
                ->update([
                    'nick' => $request->nick,
                    'picture' => null,
                    'names' => $request->names,
                    'surname_pat' => $request->surname_pat,
                    'surname_mat' => $request->surname_mat,
                    '_current_workpoint' => $request->_current_workpoint,
                    '_state' => $request->_state
                ]);
        if($result){
            return response()->json([
                'msg' => 'Los datos se han actualizado correctamente',
                'status' => 201
            ]);
        }
        return response()->json([
            'msg' => 'No se han podido actualizar los datos',
            'status' => 202
        ]);
    }
    /**
     * Función para actualizar la contraseña
     */
    public function updatePassword(){
        $message = [
            'required' => 'Este campo es necesario',
        ];
        $this->validate($request, [
            'id' => 'required',
            'password' => 'required'
        ]);

        $result = DB::table('accounts')
                ->where('id', $request->id)
                ->update(['password' => $request->password]);
        if($result){
            return response()->json([
                'msg' => 'Se ha actualizado correctamente la contraseña',
                'status' => 201
            ]);
        }
        return response()->json([
            'msg' => 'No se ha podido actualizar la contraseña',
            'status' => 202
        ]);     
    }

    public function authenticate(Request $request){
        $message = ['required' => 'Este campo es requerido'];
        $this->validate($request, [
            'nick' => 'required',
            'password' => 'required'
        ], $message);

        $account = Account::where('nick', $request->nick)->first();
        
        if(!$account){
            return response()->json([
                'status' => 404,
                'msg' => 'La cuenta no existe.',
                ]);
            }
        $account = $account->fresh('state', 'workpoint', 'rol', 'modules', 'permissions');
        if(Hash::check($request->password, $account->password)){
            if($account->_state == 3){
                return response()->json([
                    'status' => 202,
                    'msg' => 'Cuenta bloqueada'
                ]);
            }
            return response()->json([
                'status' => 200,
                'token' => $this->jwt($account),
                'account' => $this->customAccount($account),
            ]);
        }
        return response()->json([
            'status' => 404,
            'msg' => 'La cuenta o la contraseña es incorrecta'
        ]);
    }

    public function joinPermissions($modules, $permissions){
        return $modules->map( function ($module) use ($permissions){
            unset($module['pivot']);
            $module->permissions = $permissions->filter( function($permission) use ($module){
                unset($permission['pivot']);
                return $permission->_module == $module->id;
            });
            return $module;
        });
    }

    public function customAccount(Account $account){
        return [
            'nick' => $account->nickname,
                    'picture' => $account->picture,
                    'names' => $account->names,
                    'surname_pat' => $account->surname_pat,
                    'surname_mat' => $account->surname_mat,
                    'created_at' => $account->created_at,
                    'updated_at' => $account->updated_at,
                    '_current_workpoint' => $account->workpoint,
                    '_state' => $account->state,
                    '_rol' => $account->rol,
                    'modules' => $this->joinPermissions($account->modules, $account->permissions)
        ];
    }

    public function checkHierarchy($accFrom, $accTo){
        if($accFrom['_rol'] == $accTo['_rol']->id){
            return true;
        }else{
            return false;
        }
    }
}