<?php
namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Account;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class JwtMiddleware{
    public function handle($request, Closure $next, $guard = null){
        $bearerToken = $request->header('Authorization');
        $token = null;
        if($bearerToken){
            $token = explode(" ", $bearerToken)[1];
        }
        if(!$token){
            return response()->json([
                'msg' => 'No se ha proporcionado token',
                'status' => 404,
            ]);
        }
        try{
            $credentials = JWT::decode($token, env('JWT_SECRET'),['HS256']);
        } catch(ExpiredException $e){
            return response()->json([
                'msg' => 'El token ha expirado',
                'status' => 404
            ]);
        } catch(Exception $e){
            return response()->json([
                'msg' => 'No se ha proporcionado un token válido',
                'status' => 500,
            ]);
        }
        /**
         * Se buscan los datos del usuario que ha iniciado sesión
         */
        $user = Account::find($credentials->sub);

        $request->auth = $user->fresh('state', 'workpoint', 'modules', 'permissions');

        return $next($request);
    }
}