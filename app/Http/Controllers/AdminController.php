<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function employees()
    {
        $employees = User::where('role_id', 2)->get();

        return view('admin.employees.index', compact('employees'));
    }

    public function createEmployee()
    {
        return view('admin.employees.create');
    }

    public function storeEmployee(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => 2,
        ]);

        return redirect()->route('admin.employees')->with('success', 'Сотрудник добавлен');
    }

    public function deleteEmployee($id)
    {
        $user = User::where('role_id', 2)->findOrFail($id);
        $user->delete();

        return redirect()->route('admin.employees')->with('success', 'Сотрудник удалён');
    }
}
