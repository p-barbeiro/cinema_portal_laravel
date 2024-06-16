<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class UserController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;


    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    public function index(Request $request)
    {
        $filterByName = $request->input('name');
        $filterByType = $request->input('type');
        $usersQuery = User::query();
        if ($filterByType !== null) {
            $usersQuery->where('type', $filterByType);
        }
        if ($filterByName !== null) {
            $usersQuery->where('name', 'LIKE', '%' . $filterByName . '%');
        }

        $users = $usersQuery
            ->orderBy('name')
            ->where('type', '!=', 'C')
            ->paginate(10)
            ->withQueryString();

            return view('users.index', compact('users','filterByName','filterByType'));
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
        $user->update($request->validated());
        if ($user->email != $request->email) {
            $validated = $request->validate(['email' => 'unique:users,email']);
            $user->update(
                ['email' => $validated['email']]);
        }

        if ($request->hasFile('photo_filename')) {
            if ($user->photo_filename &&
                Storage::fileExists('public/photos/' . $user->photo_filename)) {
                Storage::delete('public/photos/' . $user->photo_filename);
            }
            $path = $request->photo_filename->store('public/photos');
            $user->photo_filename = basename($path);
            $user->save();
        }

        return redirect()->route('users.edit', ['user' => $user])
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

    public function create(): View
    {
        $newUser = new User();
        return view('users.create')->with('users', $newUser);
    }
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'photo_filename' => 'nullable|image|max:10240', // Example validation for image upload //TODO
            'type' => ['required', 'in:E,A']
        ]);

        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = Hash::make($validatedData['password']);
        $user->type = $validatedData['type'];
        $user->blocked = 0;

        if ($request->hasFile('photo_filename')) {
            $path = $request->photo_filename->store('public/photos');
            $user->photo_filename = basename($path);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User created successfully.'); //TODO mostrar que fez com sucesso
    }
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('alert-msg', 'User "' . $user->name . '" was deleted successfully.')
            ->with('alert-type', 'success');
    }


}
