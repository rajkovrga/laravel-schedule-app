<?php

namespace App\Filament\Resources\CompanyJobResource\Pages;

use App\Filament\Resources\CompanyJobResource;
use App\Utils\Roles;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCompanyJob extends CreateRecord
{
    protected static string $resource = CompanyJobResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = auth()->user()->company_id;
        if(!auth()->user()->hasRole(Roles::Admin)) {
            $data['company_id'] = auth()->user()->company_id;
        }

        return $data;
    }
}
