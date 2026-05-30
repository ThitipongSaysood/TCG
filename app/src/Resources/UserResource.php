<?php

namespace App\Src\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'display_name'    => $this->display_name,
            'email'           => $this->email,
            'phone'           => $this->phone,
            'avatar_url'      => $this->avatar_url,
            'login_provider'  => $this->login_provider,
            'membership_tier' => $this->membership_tier,
            'total_spent'     => (float) $this->total_spent,
            'auction_wins'    => $this->auction_wins,
            'role'            => $this->role,
            'status'          => $this->status,
            'wallet'          => $this->whenLoaded('wallet', fn () => [
                'balance'        => (float) $this->wallet->balance,
                'locked_balance' => (float) $this->wallet->locked_balance,
            ]),
            'created_at'      => $this->created_at?->toIso8601String(),
        ];
    }
}
