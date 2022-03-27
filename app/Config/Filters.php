<?php

namespace Config;

use App\Filters\FilterAdmin;
use App\Filters\FilterGuru;
use App\Filters\FilterKursus;
use App\Filters\FilterPesan;
use App\Filters\FilterSiswa;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array
     */
    public $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'FilterAdmin'   => FilterAdmin::class,
        'FilterGuru'    => FilterGuru::class,
        'FilterSiswa'   => FilterSiswa::class,
        'FilterPesan'   => FilterPesan::class,
        'FilterKursus'  => FilterKursus::class,
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array
     */
    public $globals = [
        'before' => [
            'FilterAdmin' => [
                'except' => [
                    'home', 'home/*',
                    'auth', 'auth/*',
                    'login', 'login/*',
                    '/'
                ]
            ],
            'FilterGuru' => [
                'except' => [
                    'home', 'home/*',
                    'auth', 'auth/*',
                    'login', 'login/*',
                    '/'
                ]
            ], 'FilterSiswa' => [
                'except' => [
                    'home', 'home/*',
                    'login', 'login/*',
                    'auth', 'auth/*',
                    '/'
                ]
            ]
            // 'honeypot',
            // 'csrf',
            // 'invalidchars',
        ],
        'after' => [
            'FilterAdmin' => [
                'except' => [
                    'home', 'home/*',
                    'admin', 'admin/*',
                    '/',
                ]
            ],
            'FilterGuru' => [
                'except' => [
                    'guru', 'guru/*',
                ]
            ],
            'FilterSiswa' => [
                'except' => [
                    'siswa', 'siswa/*',
                    'login', 'login/*',
                ]
            ],
            'toolbar',
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['csrf', 'throttle']
     *
     * @var array
     */
    public $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array
     */
    public $filters = [];
}
