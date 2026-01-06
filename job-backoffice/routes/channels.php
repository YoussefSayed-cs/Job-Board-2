<?php

use Illuminate\Support\Facades\Broadcast;

// Only register channels if broadcasting is enabled
if (config('broadcasting.default') !== 'null') {
    Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
        return (string) $user->id === (string) $id;
    });
}
