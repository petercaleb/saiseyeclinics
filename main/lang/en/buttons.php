<?php

return array(

    'users' => array(
        'inventory' => array(
            'receive_hq' => 'Receive From HQ',
            'receive_clinic' => 'Receive From Clinic',
            'request_frame' => 'Request Frame',
            'request_case' => 'Request Case',
        ),
    ),

    'admins' => array(
        'inventory' => array(
            'frames' => array(
                'stocks' => 'Add Frame Stocks',
            ),
            'cases' => array(
                'stocks' => 'Add Case Stocks',
            ),
            'lenses' => array(
                'stocks' => 'Add Lens Stock',
            ),
        ),
    ),

    'technicians' => array(
        'inventory' => array(
            'receive_hq' => 'Receive From HQ',
            'receive_clinic' => 'Receive From Clinic',
            'request_frame' => 'Request Frame',
            'request_case' => 'Request Case',
            'request_lens' => 'Request Lens'
        ),
    ),

    'general' =>
    array(
        'crud' =>
        array(
            'edit' => 'Edit',
            'delete' => 'Delete',
            'view' => 'View',
            'create' => 'Create',
            'update' => 'Update',
            'generate' => 'Generate',
        ),
        'cancel' => 'Cancel',
        'continue' => 'Continue',
        'save' => 'Save',
        'view' => 'View',
    ),
    'backend' =>
    array(
        'access' =>
        array(
            'users' =>
            array(
                'unconfirm' => 'Un-confirm',
                'confirm' => 'Confirm',
                'unlink' => 'Unlink',
                'login_as' => 'Login As :user',
                'clear_session' => 'Clear Session',
                'change_password' => 'Change Password',
                'activate' => 'Activate',
                'deactivate' => 'Deactivate',
                'resend_email' => 'Resend Confirmation E-mail',
                'delete_permanently' => 'Delete Permanently',
                'restore_user' => 'Restore User',
            ),
        ),
    ),
    'emails' =>
    array(
        'auth' =>
        array(
            'confirm_account' => 'Confirm Account',
            'reset_password' => 'Reset Password',
        ),
    ),
);
