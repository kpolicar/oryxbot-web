<?php namespace App\Models\Traits;


trait UserThrottles
{
    public function getNotificationRateLimitPerMinuteAttribute()
    {
        return 5 * $this->subscription_instances; // 5 per minute for each subscription
    }
}
