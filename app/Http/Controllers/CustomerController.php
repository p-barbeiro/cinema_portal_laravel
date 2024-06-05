<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

        $customers = $customersQuery
            ->orderBy('users.name')
            ->with('user')
            ->paginate(10)
            ->withQueryString();

        return view('customers.index', compact('customers', 'filterByName'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', ['customer' => $customer]);
    }

    public function show(User $user)
    {
        return view('users.show', ['user' => $user]);
    }

//    public function update(UserFormRequest $request, User $user)
//    {
//        //TODO
//        $user->update($request->validated());
//        $user->save();
//        return redirect()->route('user.edit', ['user' => $user])
//            ->with('alert-msg', 'User "' . $user->name . '" foi alterado com sucesso!')
//            ->with('alert-type', 'success');
//    }

    public function purchases(Request $request): View
    {
        $user = auth()->user();
        $purchases = Purchase::where('customer_id', $user->id)
            ->orderBy('id', 'desc')
            ->with('tickets','tickets.screening','tickets.seat', 'tickets.screening.movie')
            ->paginate(8);
        return view('customers.purchases', compact('purchases'));
    }
}

/*
 *
    //Dados clientes update
    public function cliente_update(Request $request)
   {
      $user = auth()->user();
      $random = Str::random(10);
      //dd(strlen($request->nif));
      //valida se houver alterações
      if ($request->name == $user->name and $request->nif == $user->Cliente->nif and $request->tipo_pagamento == $user->Cliente->tipo_pagamento and $request->foto_url == null) {
         return back()
                ->with('alert-msg', 'Sem dados a alterar')
                ->with('alert-type', 'success');
      }


      //update nome
      if($request->name){
         $validatedData = $request->validate(['name' => 'required|max:50']);
         User::where('id', $user->id)->update(['name' => $validatedData['name']]);
      }
      //update nif
      if($request->nif){
         if (strlen($request->nif) == 9) {
         $validatedData = $request->validate(['nif' => 'required']);
         Cliente::where('id', $user->id)->update(['nif' => $validatedData['nif']]);
      }else{
         return back()
             ->with('alert-msg', 'NIF invalido')
             ->with('alert-type', 'success');
      }
      }
      //update tipo_pagamento
      if($request->tipo_pagamento){
         if ($request->tipo_pagamento != 'NENHUM') {
            Cliente::where('id', $user->id)->update(['tipo_pagamento' => $request->tipo_pagamento]);
         }
      }
      //update foto
      if($request->foto_url){
         $nameFile = ($user->id . '_'. $random . '.' . $request->foto_url->extension());
         $request->foto_url->move(public_path('storage/fotos'), $nameFile);
         User::where('id', $user->id)
              ->update(['foto_url' => $nameFile]);
      }




        return back()
            ->with('alert-msg', 'Dados atualizados com sucesso!')
            ->with('alert-type', 'success');
    }
 */
