<?php

namespace App\Http\Controllers\V1;

use App\Events\V1\Auth\EmailVerificationEvent;
use App\Events\V1\Auth\LoginEvent;
use App\Events\V1\Auth\RestPasswordEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\ChangePasswordRequest;
use App\Http\Requests\V1\Admin\EmailVerificationRequest;
use App\Http\Requests\V1\Admin\ForgetPasswordRequest;
use App\Http\Requests\V1\Admin\LoginRequest;
use App\Http\Requests\V1\Admin\RestPasswordRequest;
use App\Http\Resources\V1\starter\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Otp;

class AuthController extends Controller
{


    private $otp;
    public function __construct()
    {
        $this->otp = new Otp;
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->validated();
            if (!Auth::attempt($credentials)) {
                throw new \Exception("les informations d'identification fournies ne sont pas correctes.");
            }
            $user = User::where('email', $request->email)->first();

            if (config('defaultUserRole.delete_previous_access_tokens_on_login', false)) {
                $user->tokens()->delete();
            }
            $roles = $user->roles->pluck('slug')->all();
            event(new LoginEvent($user));
            $plainTextToken = $user->createToken("Api Token ", $roles)->plainTextToken;
            $user->loadMissing('occupation');
            $user->loadMissing('education');
            $user->loadMissing('personnelInfo');
            return response()->json([
                "user" => new UserResource($user),
                "token" => $plainTextToken,

            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Une erreur s'est produite lors de la connexion",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function logout()
    {
        try {
            Auth::user()->currentAccessToken()->delete();


            return response()->json([
                'message' => 'Vous avez été déconnecté avec succès',

            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "une erreur s'est produite lors de la déconnexion",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function emailVerification(EmailVerificationRequest $request)

    {
        try {
            $otp2 = $this->otp->validate($request->email, $request->code);
            if (!$otp2->status) {
                return response()->json(["error" => $otp2], 401);
            }
            $user = User::where("email", $request->email)->first();
            $user->email_verified_at = now();
            $user->update();
            $roles = $user->roles->pluck('slug')->all();
            $plainTextToken = $user->createToken("Api Token ", $roles)->plainTextToken;
            $user->loadMissing('occupation');
            $user->loadMissing('education');
            $user->loadMissing('personnelInfo');
            return response()->json([
                "user" => new UserResource($user),
                "token" => $plainTextToken,
            ], 201);
        } catch (\Exception $e) {
            return response([
                "error" => "Quelque chose s'est mal passé, vous ne pouvez pas vous inscrire pour le moment"
            ], 500);
        }
    }
    public function reSendEmailVerification(String $string, Request  $request, User $user)
    {
        try {

            event(new EmailVerificationEvent($user));

            return response()->json([
                'message' => 'Vous avez reçu avec succès un nouveau code de vérification'

            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Une erreur s'est produite lors  du renvoi du nouveau code de vérification à votre adresse e-mail",
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function forgotPassword(ForgetPasswordRequest $request)
    {
        try {
            $input = $request->only("email");
            $user = User::where("email", $input)->first();
            event(new RestPasswordEvent($user));

            return response()->json([
                'message' => 'vous avez été notifié avec succès vérifiez votre e-mail'

            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Une erreur s'est produite lors  du renvoi du nouveau code de vérification à votre adresse e-mail",
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function resetPassword(RestPasswordRequest $request)
    {
        try {
            $otp2 = $this->otp->validate($request->email, $request->code);
            if (!$otp2->status) {
                return response()->json(["error" => $otp2], 401);
            }
            $user = User::where("email", $request->email)->first();
            $user->update(["password" => bcrypt($request->password)]);
            $user->tokens()->delete();
            return response()->json([
                'message' => 'Vous avez changé votre mot de passe avec succès, vous devez vous connecter avec celui-ci'

            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Une erreur s'est produite lors  du renvoi du nouveau code de vérification à votre adresse e-mail",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function changePassword(String $lang, ChangePasswordRequest $request, User $user)
    {
        try {
            $request->validated();
            $credentials = [
                'email' => $user->email,
                'password' => $request->password
            ];

            if (!Auth::guard('web')->attempt($credentials)) {

                throw new \Exception("votre  mot de passe actuel que vous avez saisi n'est pas correct.");
            }
            $user["password"] = Hash::make($request->new_password);
            $user->update();
            Auth::user()->currentAccessToken()->delete();
            return response()->json([
                'message' => 'password changed successfully',
                'user' => new UserResource($user)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Une erreur s'est produite lors du changement de mot de passe",
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
