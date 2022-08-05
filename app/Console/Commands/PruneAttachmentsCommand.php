<?php

namespace App\Console\Commands;

use App\Jobs\RemoveOrphanAttachments;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;

/**
 * @see docs/attachments.md
 */
final class PruneAttachmentsCommand extends Command
{
    protected $signature = 'attachments:prune
                            {--before=-1 day : Prune attachments before this date}';
    protected $description = 'Remove orphan attachments';

    public function handle(): int
    {
        $before = Date::parse($this->option('before'));

        $this->info("Removing orphan attachments before {$before->toIso8601String()}");
        RemoveOrphanAttachments::dispatchSync($before);

        $this->info('Done!');

        return self::SUCCESS;
    }
}
