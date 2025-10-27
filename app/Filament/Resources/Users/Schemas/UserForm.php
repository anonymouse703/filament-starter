<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\User\Role;
use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Validation\Rules\Password;
use Filament\Forms\Components\DateTimePicker;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->default(fn () => Str::password(8))
                    ->minLength(8)
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->revealable()
                    ->rule(Password::min(8)
                        ->letters()
                        ->numbers()
                        ->symbols()
                        ->mixedCase()
                    )
                    ->inlineSuffix()
                    ->copyable(copyMessage: 'Copied!', copyMessageDuration: 1500),
                Select::make('role')
                    ->options(Role::class)
                    ->required(),
            ]);
    }
}
