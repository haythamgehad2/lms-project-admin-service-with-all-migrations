<?php

namespace App\Console\Commands;

use App\Integrations\Vimeo\Vimeo;
use App\Models\VideoBank;
use Illuminate\Console\Command;

class SyncVimeoVideoStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-vimeo-video-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command to check the uploaded videos statuses from vimeo gateway';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        VideoBank::whereHas("vimeo", fn($q) => $q->notFullUploaded())
            ->with("vimeo")
            ->lazy()
            ->each(function($videoBank) {
                if ((Vimeo::getVimeoVideo($videoBank)["status"] ?? "") == "complete") {
                    $videoBank->vimeo->update(['is_fully_uploaded' => true]);
                }
            });

        VideoBank::whereHas("vimeoWithoutMusic", fn($q) => $q->notFullUploaded())
            ->with("vimeoWithoutMusic")
            ->lazy()
            ->each(function($videoBank) {
                if ((Vimeo::getVimeoWithoutMusic($videoBank)["status"] ?? "") == "complete") {
                    $videoBank->vimeoWithoutMusic->update(['is_fully_uploaded' => true]);
                }
            });
    }
}
