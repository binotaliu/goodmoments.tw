<?php

namespace App\Jobs;

use App\Models\Attachment;
use DateTimeInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class RemoveOrphanAttachments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly DateTimeInterface $before
    ) {
    }

    public function handle(): bool
    {
        return Attachment
            ::query()
            ->where('created_at', '<=', $this->before)
            ->whereDoesntHave('attachmentables')
            ->delete();
    }
}
