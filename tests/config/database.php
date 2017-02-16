<?php

return [

    'connections' => [

        'riak' => [
            'name'                 => 'riak',
            'driver'               => 'riak',
            'port'                 => '8098',
            'clusters'             => ['localhost'],
            'prefix'               => 'riak',
            'mapred_prefix'        => 'mapred',
            'index_prefix'         => 'buckets',
            'dns_server'           => '8.8.8.8',
            'max_connect_attempts' => 3,
        ],

        'mysql' => [
            'driver'    => 'mysql',
            'host'      => '127.0.0.1',
            'database'  => 'unittest',
            'username'  => 'travis',
            'password'  => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ],
    ],

];
