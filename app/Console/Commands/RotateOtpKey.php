<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RotateOtpKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:rotate-otp-key';

    protected $description = 'Automatically rotate OTP secret keys';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Generate a new OTP secret key
        $newKey = bin2hex(random_bytes(32));  // Generates a 64-character hex string

        // Get the current content of .env file
        $envFilePath = base_path('.env');
        $envContent = File::get($envFilePath);

        // Replace the previous key with the current key and set the new key
        $updatedEnvContent = preg_replace(
            '/OTP_PREVIOUS_SECRET_KEY=(.*)/',
            'OTP_PREVIOUS_SECRET_KEY=' . env('OTP_SECRET_KEY'),
            $envContent
        );
        $updatedEnvContent = preg_replace(
            '/OTP_SECRET_KEY=(.*)/',
            "OTP_SECRET_KEY=$newKey",
            $updatedEnvContent
        );

        // Save the new content to .env
        File::put($envFilePath, $updatedEnvContent);

        // Clear config cache to load the new keys
        $this->call('config:clear');

        // Log the key rotation
        $this->info('OTP secret keys rotated successfully.');

    }
}
