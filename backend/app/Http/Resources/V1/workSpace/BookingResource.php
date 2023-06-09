<?php

namespace App\Http\Resources\V1\workSpace;

use App\Http\Resources\V1\starter\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

            return [
                'id' => $this->id,
                'workspaceId' => $this->workspace_id,
                'userId' => $this->user_id,
                'planId' => $this->plan_id,
                'startDate' => $this->start_date,
                'endDate' => $this->end_date,
                'startTime' => $this->start_time,
                'endTime' => $this->end_time,
                'paymentStatus' => $this->payment_status,
                'totalPrice' => $this->total_price,
                'workspace' => new WorkSpaceResource($this->whenLoaded('workspace')),
                'user' => new UserResource($this->whenLoaded('user')),
                'plan' => new PlanResource($this->whenLoaded('plan')),
            ];

    }
}
