<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfigurationFormRequest;
use App\Models\Configuration;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ConfigurationController extends Controller
{
    public function show(Configuration $config): View
    {
        $config = Configuration::first();
        return view('configurations.show')
            ->with('configs', $config);
    }

    public function edit(Configuration $config): View
    {
        $config = Configuration::first();
        return view('configurations.edit')
            ->with('configs', $config);
    }

    public function update(ConfigurationFormRequest $request, Configuration $config): RedirectResponse
    {
        $config = Configuration::first();
        $config->update($request->validated());

        $htmlMessage = "Configurations has been updated successfully!";
        return redirect()->route('configurations.show', ['configuration' => $config])
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }
}
