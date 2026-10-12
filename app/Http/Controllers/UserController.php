<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'You do not have permission to perform this action.');
        }
        $users = User::orderBy('created_at', 'DESC')
            ->get();

        return view('user.index', ['users' => $users]);
    }

    public function store(Request $request)
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'You do not have permission to perform this action.');
        }
        $validator = Validator::make($request->all(), User::$rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $requestData = $request->all();

        // Hash the password before saving
        if (isset($requestData['password'])) {
            $requestData['password'] = bcrypt($requestData['password']);
        }
        
        $requestData['is_admin'] == 1 ? true : false;


        $user = User::create($requestData);

        if ($user) {
            return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
        } else {
            return response()->json(['message' => 'Failed to create user'], 500);
        }
    }



    public function create()
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'You do not have permission to perform this action.');
        }
        return view('user.create');
    }

    public function edit($id)
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'You do not have permission to perform this action.');
        }
        $user = User::find($id);

        return view('user.edit', ['user' => $user]);
    }

    public function show(User $user)
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'You do not have permission to perform this action.');
        }
        return $user;
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'You do not have permission to perform this action.');
        }
        $user = User::where('id', $id)->first();
        $rules = User::$rules;
        $rules['email'] = 'required|email|unique:users,email,' . $user->id;
        $rules['password'] = 'nullable|string|min:8';

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $requestData['is_admin'] = $request->is_admin == 1 ? true : false;

        $requestData = $request->except(['password']); // Exclude password by default

        // Update password only if provided and not null
        if (!empty($request->password)) {
            $requestData['password'] = bcrypt($request->password);
        }


        $user->update($requestData);

        return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
    }


    public function destroy($id)
    {
        $user = User::find($id);

        if (!Auth::user()->is_admin) {
            abort(403, 'You do not have permission to perform this action.');
        }

        $hasPayments = Payment::withTrashed()
            ->where('user_id', $user->id)
            ->exists();
        if ($hasPayments) {
            return back()->with('message', 'Cannot delete user: it has related payments.');
        }

        $hasOrders = DB::table('orders')->where('user_id', $user->id)->exists();
        if ($hasOrders) {
            return back()->with('message', 'Cannot delete user: it has related orders.');
        }

        $user->delete();
        return back()->with('message', 'User deleted successfully');
    }
}

