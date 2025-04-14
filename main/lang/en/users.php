<?php

return [
    'page' => [
        'dashboard' => [
            'title' => 'Dashboard'
        ],
        'patients' => [
            'title' => 'Patients',
            'sub_page' => [
                'patients' => 'Patients',
                'add_new' => 'New Patient',
                'view' => 'Profile',
                'appointment' => 'Appointments',
                'schedule' => 'Doctor\'s Schedules',
                'payments' => 'Payments',
                'orders' => 'Orders',
                'edit' => 'Update Patient Details'
            ],
        ],
        'appointments' => [
            'title' => 'Appointments',
            'sub_page' => [
                'appointment' => 'Appointment',
                'new' => 'New Appointment',
                'view' => 'Appointment Details'
            ],
        ],
        'schedules' => [
            'title' => 'Schedules',
            'sub_page' => [
                'schedules' => 'All Schedules',
                'my_schedules' => 'My Schedules',
                'view' => 'View Schedule',
                'view_personal' => 'View Personal Schedule'
            ],
        ],
        'payments' => [
            'title' => 'Payments',
            'sub_page' => [
                'payments' => 'Payment Bills',
                'view' => 'View Bill',
                'edit' => 'Edit Bill',
                'closed' => 'Closed Bills',
                'view_closed' => 'View Closed Bill',
                'remittance' => 'Remittance',
            ],
        ],
        'orders' => [
            'title' => 'Orders',
            'sub_page' => [
                'view' => 'Order Details'
            ]
        ],

        'inventory' => [

            'frames' => [
                'title' => 'Frame Stocks',
            ],
            'title' => 'Inventory',
            'sub_page' => [
                'frames' => 'Frames',
                'cases' => 'Cases'
            ],
        ],

        'doctors' => [
            'title' => 'Doctors/ Optimetrist'
        ],

    ],

    'header' => [
        'inventory' => 'Inventory',
        'users' => 'Users Access',
    ], 
];
