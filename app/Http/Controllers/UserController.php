<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Gate;

use App\Http\Requests;
use App\User;
use Exception, InvalidArgumentException;
use Yajra\Datatables\Datatables;

class UserController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('rkt.show');
        }

        return view('login');
    }

    public function postLogin(Request $request)
    {
        $email    = $request->input('email') . "@lemsaneg.go.id";
        $password = $request->input('password');
        
        return $this->login($email, $password);
    }

    protected function login($email, $password)
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            // Authentication passed...
            return redirect()->intended(route('rkt.show'));
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('user.login');
    }

    public function manage()
    {
        if (Gate::denies('user-manage')) {
            return response(view('error', [
                'error' => [
                    'number'  =>'403', 
                    'message' => 'Akses tidak diperkenankan',
                    'path'    => 'Manage User'
                ]
            ]), 403);
        }

        return view('user-manage');
    }

    public function get($email = null)
    {
        $email = $email . "@lemsaneg.go.id";

        return response()->json(
            User::where('email', $email)->firstOrFail() ?  1 : 0
        );
    }

    public function postCreate(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required',
            'email'    => 'required|max:255|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        try {
            $name      = $request->input("name");
            $email     = $request->input("email");
            $password  = $request->input("password");
            
            $user           = new User;
            $user->name     = $name;
            $user->email    = $email . "@lemsaneg.go.id";
            $user->password = bcrypt($password);
            $user->save();

            return response()->json(["message" => "Data berhasil disimpan"]);

        } catch (Exception $e) {

            return response()->json([
                "error" => $e->getCode(), "message" => $e->getMessage()], 500
            );
        }        
    }

    public function delete($id)
    {
        try {
            $data = User::findOrFail($id);

            $data->delete();
            
            return response()->json(["message" => "Data berhasil dihapus"]);

        }  catch (Exception $e) {

            return response()->json([
                "error" => $e->getCode(), "message" => $e->getMessage()], 500
            );
        }
    }

    public function data()
    {
        return Datatables::of(User::all())->make(true);
    }
}
