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
            ProvincesHelper::PROVINCES => $this->provinceToArray(),
            ProvincesHelper::DISTRICTS => $this->districtToArray(),
            ProvincesHelper::WARD => $this->wardToArray(),
            default => [],
        };
    }
    protected function provinceToArray() :array
    {
        return [
            "name"=>$this->name,
            "type" => $this->type,
            "code"=>$this->code,
        ];
    }

    protected function districtToArray()
    {
        return $this;
    }

    protected function wardToArray()
    {
        return $this;
    }
}
