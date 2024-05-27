<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(): View
    {
        return view('users.index');
    }

    public function create(): View
    {
        return view('users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        User::create($request->all());
        return redirect('/users');
    }

    public function edit(User $user): View
    {
        return view('users.edit')->with('user', $user);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $user->update($request->all());
        return redirect('/users');
    }
}
