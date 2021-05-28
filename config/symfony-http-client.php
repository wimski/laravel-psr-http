<?php

return [
    /**
     * @see HttpClientInterface::OPTIONS_DEFAULTS
     */
    'default_options' => [
        'auth_basic'              => null,
        'auth_bearer'             => null,
        'query'                   => [],
        'headers'                 => [],
        'body'                    => '',
        'json'                    => null,
        'user_data'               => null,
        'max_redirects'           => 20,
        'http_version'            => null,
        'base_uri'                => null,
        'buffer'                  => true,
        'on_progress'             => null,
        'resolve'                 => [],
        'proxy'                   => null,
        'no_proxy'                => null,
        'timeout'                 => null,
        'max_duration'            => 0,
        'bindto'                  => '0',
        'verify_peer'             => true,
        'verify_host'             => true,
        'cafile'                  => null,
        'capath'                  => null,
        'local_cert'              => null,
        'local_pk'                => null,
        'passphrase'              => null,
        'ciphers'                 => null,
        'peer_fingerprint'        => null,
        'capture_peer_cert_chain' => false,
        'extra'                   => [],
    ],
    'max_host_connections' => 6,
    'max_pending_pushes'   => 50,
];
