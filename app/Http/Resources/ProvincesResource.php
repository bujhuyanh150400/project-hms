<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Helper\Provinces as ProvincesHelper;

class ProvincesResource extends JsonResource
{

    public function toArray($request): array
    {
        $resourceType = $request->input('resource_type', ProvincesHelper::PROVINCES);
        return match ($resourceType) {
            ProvincesHelper::PROVINCES => $this->provinceToArray($this->resource),
            ProvincesHelper::DISTRICTS => $this->districtToArray($this->resource),
            ProvincesHelper::WARD => $this->wardToArray($this->resource),
            default => [],
        };
    }
    protected function provinceToArray(array $province): array
    {
        return [
            "name" => $province['name_with_type'],
            "type" => $province['type'],
            "code" => $province['code'],
        ];
    }

    protected function districtToArray(array $district): array
    {
        return [
            "name" => $district['name_with_type'],
            "type" => $district['type'],
            "code" => $district['code'],
            "parent_code" => $district['parent_code'],
        ];
    }

    protected function wardToArray(array $ward): array
    {
        return [
            "name" => $ward['name_with_type'], // Change 'name' to the actual key in the ward array
            "type" => $ward['type'],
            "code" => $ward['code'],
            "parent_code" => $ward['parent_code'],
            // Add other fields as needed
        ];
    }
}
