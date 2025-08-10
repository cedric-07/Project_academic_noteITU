<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;
use App\Models\Etudiant;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.loginAdmin');
    }

    public function createEtudiant(): View
    {
        return view('auth.loginEtudiant');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function loggedAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'pwd' => 'required',
        ], [
            'email.required' => 'Please enter your email.',
            'email.email' => 'Please enter a valid email.',
            'pwd.required' => 'Please enter your password.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $email = $request->input('email');
        $pwd = $request->input('pwd');
        $admin = Admin::where('email', $email)->first();
        if ($admin && $request->pwd == $pwd) {
            Auth::guard('admins')->login($admin);  // Utiliser le garde 'admins'
            return redirect()->route('etudiant.getetudiant');
        } else {
            return back()->withErrors([
                'email' => 'The credentials you entered did not match our records. Please double-check and try again.',
            ])->withInput();
        }
    }

    public function loggedEtudiant(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numetu' => 'required|max:10',
        ], [
            'numetu.required' => 'Please enter your numetu.',
            'numetu.max' => 'Your number is too long.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $numetu = $request->input('numetu');

        $etudiant = Etudiant::where('numetu', $numetu )->first();
        if ($etudiant) {
            Auth::guard('etudiants')->login($etudiant);  // Utiliser le garde 'proprietaires'
            return redirect()->route('semestre.getsemester' , ['semestreId'=>$etudiant->idsemestre , 'etudiantsId'=>$etudiant->idetudiant]);
        } else {
            return back()->withErrors([
                'numetu' => 'The credentials you entered did not match our records. Please double-check and try again.',
            ])->withInput();
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
