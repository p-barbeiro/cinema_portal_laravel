<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerFormRequest;
use App\Models\Customer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CustomerController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Customer::class);
    }

    public function index(Request $request): View
    {
        $filterByName = $request->search;
        $filterByPayment = $request->payment_type;

        $customersQuery = Customer::query()
            ->join('users', 'customers.id', '=', 'users.id')
            ->withExists('user');

        if ($filterByName !== null) {
            $customersQuery->where(function ($query) use ($filterByName) {
                $query
                    ->where('users.name', 'LIKE', '%' . $filterByName . '%')
                    ->orWhere('users.email', 'LIKE', '%' . $filterByName . '%')
                    ->orWhere('nif', 'LIKE', '%' . $filterByName . '%');
            });
        }

        if ($filterByPayment !== null) {
            $customersQuery->where('payment_type', $filterByPayment);
        }

        $customers = $customersQuery
            ->orderBy('users.name')
            ->with('user')
            ->paginate(10)
            ->withQueryString();

        return view('customers.index', compact('customers', 'filterByName', 'filterByPayment'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', ['customer' => $customer]);
    }

    public function show(Customer $customer)
    {
        return view('customers.show', ['customer' => $customer]);
    }

    public function block(Customer $customer): RedirectResponse
    {
        $user = $customer->user;
        if ($user->blocked == 1) {
            $user->update(['blocked' => 0]);
            return redirect()->route('customers.index')
                ->with('alert-type', 'success')
                ->with('alert-msg', "Customer <u>$user->name</u> has been unblocked successfully!");
        } else {
            $user->update(['blocked' => 1]);
            return redirect()->route('customers.index')
                ->with('alert-type', 'success')
                ->with('alert-msg', "Customer <u>$user->name</u> has been blocked successfully!");
        }
    }

    public function update(CustomerFormRequest $request, Customer $customer)
    {
        $user = $customer->user;

        $validated = $request->validated();

        $customer->update([
            'nif' => $validated['nif'],
            'payment_type' => $validated['payment_type'],
            'payment_ref' => $validated['payment_ref'],
        ]);

        if ($user->email != $request->email) {
            $validated = $request->validate(['email' => 'unique:users,email']);
            $user->update(
                ['email' => $validated['email']]);
        }
        if ($request->has('name')) {
            $user->update([
                'name' => $validated['name'],
            ]);
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

        return redirect()->route('customers.show', ['customer' => $customer])
            ->with('alert-msg', 'Customer "' . $user->name . '" has been updated successfully!')
            ->with('alert-type', 'success');
    }

    public function destroy(Customer $customer): RedirectResponse
    {
        $user = $customer->user;
        $customer->delete();
        $user->delete();
        return redirect()->route('customers.index')
            ->with('alert-msg', 'Customer "' . $user->name . '" has been deleted successfully!')
            ->with('alert-type', 'success');
    }
}
