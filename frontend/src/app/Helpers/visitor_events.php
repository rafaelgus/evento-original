<?php

use EventoOriginal\Core\Persistence\Repositories\VisitorLandingRepository;
use EventoOriginal\Core\Services\VisitorLandingService;

function visitor_landing_id()
{
    return session()->get('visitorLandingId');
}

function user_agent()
{
    return array_get($_SERVER, 'HTTP_USER_AGENT', 'UNKNOWN');
}

function visitor_url()
{
    return $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . $_SERVER['QUERY_STRING'];
}

function visitor_ip()
{
    return array_get(
        $_SERVER,
        'HTTP_CF_/**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;CONNECTING_IP',
        array_get(
            $_SERVER,
            'HTTP_X_FORWARDED_FOR',
            array_get(
                $_SERVER,
                'REMOTE_ADDR',
                'UNKNOWN'
            )
        )
    );
}

function visitorData()
{
    return [
        'ip' => visitor_ip(),
        'user_agent' => mb_substr(user_agent(), 0, 255),
        'url' => mb_substr(visitor_url(), 0, 255),
        'visitor_landing_id' => session()->get('visitorLandingId'),
    ];
}

function current_visitor_landing()
{
    $visitor_landing_id = visitor_landing_id();

    $visitorLanding = app()->make(VisitorLandingRepository::class)->findOneById($visitor_landing_id);

    return $visitorLanding;
}

function pushVisitorEvent(string $type, array $payload = [])
{
    $service = app()->make(\EventoOriginal\Core\Services\VisitorEventService::class);

    $data = array_merge(visitorData(), $payload);
    $data['type'] = $type;

    return $service->create($data);
}
