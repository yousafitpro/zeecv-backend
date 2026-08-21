<?php

namespace App\Http\Controllers\Job\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    private $filters;
    public function __construct($resource, $filters = [])
    {
        parent::__construct($resource);
        $this->filters = $filters;
    }
    public function toArray(Request $request): array
    {
        
        return array_merge([
            'id'        => unique_encrypt($this->id),
            'updated_at'  => $this->updated_at,
            'slug'  => $this->slug,
            'company_name'  => $this->company_name,
            'title'  => $this->title,
            'remote'  => $this->remote,
            'url'  => $this->url,
            'tags'  => $this->tags,
            'job_types'  => $this->job_types,
            'location'  => $this->location,
            'job_created_at'  => $this->job_created_at,
            'description'  => $this->description,
            'type'  => $this->type,
        ]);
    }
}
