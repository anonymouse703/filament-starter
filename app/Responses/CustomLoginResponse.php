<?php

namespace App\Responses;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Filament\Http\Responses\Auth\LoginResponse;
use Livewire\Features\SupportRedirects\Redirector;

class CustomLoginResponse extends LoginResponse
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        $components = $request->input('components', []);
        $password = $components[0]['updates']['data.password'] ?? null;

        if ($password) {
            Auth::logoutOtherDevices($password);
        }

        $this->deleteOtherSessionRecords($request);

        return parent::toResponse($request);
    }

    public function deleteOtherSessionRecords($request)
    {
        if (config('session.driver') !== 'database'){
            return;
        }

        DB::connection(config('session.connection'))->table(config('session.table','sessions'))
            ->where('user_id', $request->user()->getAuthIdentifier())
            ->where('id', '!=', $request->session()->getId())
            ->delete();
    }
}
