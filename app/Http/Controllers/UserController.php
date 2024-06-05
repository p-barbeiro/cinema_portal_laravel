<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UserController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    public function index(Request $request): View
    {
        $users = User::query()
            ->orderBy('name')
            ->where('type', '!=', 'C')
            ->paginate(10)
            ->withQueryString();

        return view('users.index', ['users' => $users]);
    }

    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    public function show(User $user)
    {
        return view('users.show', ['user' => $user]);
    }

    public function update(UserFormRequest $request, User $user)
    {
        //TODO
        $user->update($request->validated());
        $user->save();
        return redirect()->route('user.edit', ['user' => $user])
            ->with('alert-msg', 'User "' . $user->name . '" foi alterado com sucesso!')
            ->with('alert-type', 'success');
    }

    public function destroyPhoto(User $user): RedirectResponse
    {
        if ($user->photo_filename) {
            if (Storage::fileExists('public/photos/' . $user->photo_filename)) {
                Storage::delete('public/photos/' . $user->photo_filename);
            }
            $user->photo_filename = null;
            $user->save();

            return redirect()->back()
                ->with('alert-type', 'success')
                ->with('alert-msg', "Photo of {$user->name} has been deleted.");
        }
        return redirect()->back();
    }

}
