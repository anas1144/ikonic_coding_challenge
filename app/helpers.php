<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


if (!function_exists('getSuggestionCount')) {

    function getSuggestionCount()
    {
        $currentUserId = Auth::id();
        $suggestions = User::whereNotIn('id', function ($q) use ($currentUserId) {
            $q->select('request_id')
                ->from('requests')
                ->where('user_id', $currentUserId);
        })->whereNotIn('id', function ($q) use ($currentUserId) {
            $q->select('user_id')
                ->from('requests')
                ->where('request_id', $currentUserId);
        })->where('id', '!=', $currentUserId);

        return $suggestions->count();
    }

}

if (!function_exists('getRequestsToCount')) {

    function getRequestsToCount()
    {
        return Auth::user()->pendingRequestsTo()->count();
    }

}
if (!function_exists('getRequestsFromCount')) {

    function getRequestsFromCount()
    {
        return Auth::user()->pendingRequestsFrom()->count();
    }

}

if (!function_exists('getConnectionCount')) {

    function getConnectionCount()
    {
        return Auth::user()->Connections()->count();
    }

}
