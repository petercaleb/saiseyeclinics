<?php
return [
    'users' => [
        'tabs' => [
            'inventory' => [
                'frames' => [
                    'stocks' => 'Frame Stocks',
                    'received' => [
                        'title' => 'Received Frames',
                        'hq' => 'Received Frames from HQ',
                        'clinics' => 'Received Frames from Clinics',
                    ],
                    'transferred' => 'Frames Transferred',
                    'requested' => 'Frames Requested',
                ],
                'cases' => [
                    'stocks' => 'Case Stocks',
                    'received' => [
                        'title' => 'Received Cases',
                        'hq' => 'Received Cases from HQ',
                        'clinics' => 'Received Cases from Clinics',
                    ],
                    'transferred' => 'Cases Transferred',
                    'requested' => 'Cases Requested',
                ],
            ],
        ],
    ],

    'admins' => [
        'tabs' => [
            'inventory' => [
                'frames' => 'Frames',
                'cases' => [
                    'stocks' => 'Case Stocks',
                    'received' => [
                        'title' => 'Received Cases',
                        'hq' => 'Received Cases from HQ',
                        'clinics' => 'Received Cases from Clinics',
                        'workshops' => 'Received Cases from Workshops',
                    ],
                    'requested' => 'Cases Requested',
                ],
                'lenses' => [
                    'stocks' => 'Lens Stock',
                    'received' => [
                        'title' => 'Received Lenses',
                        'hq' => 'Received Lenses from HQ',
                        'workshops' => 'Received Lenses from Workshops',
                    ],
                    'requested' => 'Lenses Requested',
                ]
            ],
            'reports' => [
                'tat' => [
                    'tat_one' => 'TAT One',
                    'tat_two' => 'TAT Two'
                ],
            ],
        ],
    ],

    'technicians' => [
        'tabs' => [
            'inventory' => [
                'cases' => [
                    'stocks' => 'Case Stocks',
                    'received' => [
                        'title' => 'Received Cases',
                        'hq' => 'Received Cases from HQ',
                        'clinics' => 'Received Cases from Clinics',
                    ],
                    'requested' => 'Cases Requested',
                ],
                'lenses' => [
                    'stocks' => 'Lens Stocks',
                    'received' => [
                        'title' => 'Received Lenses',
                        'hq' => 'Received Lenses from HQ',
                        'workshops' => 'Received Lenses from Workshops',
                    ],
                    'requested' => 'Lenses Requested',
                ]
            ],
        ],
    ],
];
