<?php

namespace App\Console\Commands;

use App\Integrations\Vimeo\Vimeo;
use App\Models\VideoBank;
use Illuminate\Console\Command;

class SyncVideoToVimeo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-video-to-vimeo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command to sync uploaded video to vimeo gateway';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        VideoBank::doesntHave("firstVimeo")
            ->lazy()
            ->each(
                fn($videoBank) => Vimeo::pullUpload($videoBank)
            );
    }
}
