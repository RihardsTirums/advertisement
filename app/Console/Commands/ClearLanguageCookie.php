<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cookie;

/**
 * Command to clear the language cookie.
 */
class ClearLanguageCookie extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lang:clear-cookie';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the language preference stored in cookies';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        // Remove the language cookie
        Cookie::queue(Cookie::forget('lang'));

        $this->info('Language cookie has been cleared.');

        return 0;
    }
}
