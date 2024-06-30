<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApiResource extends JsonResource
{

    public $status;
    public $message;
    public $pagination;

    /**
     * __construct
     *
     * @param  mixed $status
     * @param  mixed $message
     * @param  mixed $resource
     * @return void
     */
    public function __construct($status, $message, $resource, $pagination)
    {
        parent::__construct($resource);
        $this->status  = $status;
        $this->message = $message;
        $this->pagination = $pagination;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'status'   => $this->status,
            'message'   => $this->message,
            'data'      => $this->resource,
            'pagination'      => $this->pagination,
        ];
    }
}
