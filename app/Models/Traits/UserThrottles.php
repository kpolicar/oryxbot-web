<?php namespace App\Models\Traits;


trait UserThrottles
{
    public function getNotificationRatePerMinuteLimitAttribute()
    {
        return 5 * $this->subscription_instances; // 5 per minute for each subscription
    }
}
