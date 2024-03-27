<?php

namespace App\Filament\Resources\CompanyJobResource\Pages;

use App\Filament\Resources\CompanyJobResource;
use App\Utils\Roles;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Str;

class ListCompanyJobs extends ListRecords
{
    protected static string $resource = CompanyJobResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (auth()->check() && !auth()->user()->hasRole(Roles::Admin)) {
            $data['company_id'] = auth()->user()->company_id;
        }

        return $data;
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
