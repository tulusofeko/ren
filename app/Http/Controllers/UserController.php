<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Gate;

use App\Http\Requests;
use App\User;
use Exception; 
use Validator;
use InvalidArgumentException;
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
        return view('login');
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
        if (Gate::denies('user-manage')) {
            return response(view('error', [
                'error' => [
                    'number'  =>'403', 
                    'message' => 'Akses tidak diperkenankan',
                    'path'    => 'Manage User'
                ]
            ]), 403);
        }

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

    public function postUpdate(User $user, Request $request)
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

        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'email'    => 'required|max:255',
        ]);

        $validator->sometimes('email', 'unique:users,email', 
            function($input) use ($user) {
                return $input->email != $user->email;
            });
        $validator->sometimes('password', 'required|min:6|confirmed', 
            function($input) {
                return !empty($input->password);
            });

        if ($validator->fails()) {

            if ($request->ajax()) {
                return response()->json($validator->messages(), 422);
            } 
                
            return redirect($prev)->withErrors($validator)->withInput();
        }

        try {
            $name      = $request->input("name");
            $email     = $request->input("email");
            
            $user->name     = $name;
            $user->email    = $email . "@lemsaneg.go.id";
            if ($request->has('password')) {
                $user->password = bcrypt($request->input("password"));
            }
            $user->save();

            return response()->json(["message" => "Data berhasil disimpan"]);

        } catch (Exception $e) {

            return response()->json([
                "error" => $e->getCode(), "message" => $e->getMessage()], 500
            );
        }        
    }

    public function profileUpdate(Request $request)
    {
        $user = Auth::user();

        $new_password = $request->input('new_password');

        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'email'    => 'required|max:255',
        ]);

        $validator->sometimes('email', 'unique:users,email', 
            function($input) use ($user) {
                return $input->email != $user->email;
            });

        $validator->sometimes('new_password', 'required|min:6|confirmed', 
            function($input) {
                return !empty($input->new_password);
            });

        if ($validator->fails()) {

            if ($request->ajax()) {
                return response()->json($validator->messages(), 422);
            } 
                
            return redirect($prev)->withErrors($validator)->withInput();
        }

        if (!empty($new_password)) {
            if (!Auth::attempt(['email' => $user->email, 'password' => $request->input('old_password')])) {
                // Authentication passed...
                return  response()->json([0], 422);
            }
        }

        try {
            $name      = $request->input("name");
            $email     = $request->input("email");
            
            $user->name     = $name;
            $user->email    = $email . "@lemsaneg.go.id";
            if ($request->has('new_password')) {
                $user->password = bcrypt($request->input("new_password"));
            }
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
        if (Gate::denies('user-manage')) {
            return response(view('error', [
                'error' => [
                    'number'  =>'403', 
                    'message' => 'Akses tidak diperkenankan',
                    'path'    => 'Manage User'
                ]
            ]), 403);
        }

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
