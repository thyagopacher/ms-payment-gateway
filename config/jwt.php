<?php

    return [
        'secret' => env('JWT_SECRET'),
        'ttl' => env('JWT_TTL', 3600),
        'algo' => env('JWT_ALGO', 'HS256'),
    ];
