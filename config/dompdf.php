<?php

return [
    'show_warnings' => false,
    'orientation' => 'portrait',
    'defines' => [
        // Change these to point to your public/fonts directory
        'font_dir' => public_path('assets/fontspdf/'),  // Updated
        'font_cache' => public_path('assets/fontspdf/'), // Updated
        'temp_dir' => sys_get_temp_dir(),
        'chroot' => realpath(base_path()),
        'allowed_protocols' => [
            'file://' => ['rules' => []],
            'http://' => ['rules' => []],
            'https://' => ['rules' => []]
        ],
        'log_output_file' => null,
        // Add this if you want to use DejaVu fonts
        'default_font' => 'dejavu sans',
    ],
];
