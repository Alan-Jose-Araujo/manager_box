<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use App\Models\User;

class PasswordResetController extends Controller {

    // Exibção formulario de esqueci a senha
    public function showForgotPasswordForm() {

        return view('/');
    }

    // Envio de redefinição de senha para o Email
    public function sendResetLinkEmail(Request $request) {

        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return response()->json([
        'success' => $status === Password::RESET_LINK_SENT,
        'message' => __($status)
        ]);
    }

    // Exibição de formulario para redefinir a senha
    public function showResetForm(Request $request, $token = null) {

        return view('/', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    // Redefinição de senha
    public function reset(Request $request) {
        
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
            return response()->json([
        'success' => $status === Password::PASSWORD_RESET,
        'message' => __($status)
        ]);
    }
}
?>