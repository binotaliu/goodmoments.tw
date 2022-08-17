<?php

declare(strict_types=1);

use App\Jobs\RemoveOrphanAttachments;
use App\Models\Attachment;
use App\Models\Attachmentable;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\post;

/**
 * @see docs/attachments.md
 */
it('uploads an image', function (): void {
    $user = User::factory()->active()->create();
    actingAs($user);

    Storage::fake('public');

    $file = UploadedFile::fake()->image('image.jpg');
    $attachment = post(route('admin.attachments.store'), [
        'file' => $file,
    ])
        ->assertStatus(201)
        ->json();

    expect($attachment)->toBeArray()
        ->toHaveKeys(['uuid', 'url', 'disk', 'path', 'mime', 'size', 'file_md5', 'meta_md5'])
        ->and($attachment['disk'])
        ->not->toBeEmpty()
        ->and($attachment['path'])
        ->not->toBeEmpty()
        ->and($attachment['mime'])
        ->toBe('image/jpeg')
        ->and($attachment['size'])
        ->toBe($file->getSize())
        ->and($attachment['url'])
        ->toBe(Storage::disk($attachment['disk'])->url($attachment['path']));

    Storage::disk('public')->assertExists($attachment['path']);

    assertDatabaseHas('attachments', [
        'uuid' => $attachment['uuid'],
    ]);
});

it('removes orphan attachments', function (): void {
    $orphanAttachment = Attachment::factory()->withImage()->create();
    $notOrphanAttachment = Attachment::factory()->withImage()->create();

    $attachmentable = new Attachmentable();
    $attachmentable->attachment_id = $notOrphanAttachment->id;
    $attachmentable->attachmentable_id = 1;
    $attachmentable->attachmentable_type = 'App\Models\User';
    $attachmentable->save();

    RemoveOrphanAttachments::dispatchSync(now()->subDay());

    // orphan should not been deleted yet as it has not been a day
    assertDatabaseHas('attachments', [
        'id' => $orphanAttachment->id,
    ]);
    assertDatabaseHas('attachments', [
        'id' => $notOrphanAttachment->id,
    ]);

    RemoveOrphanAttachments::dispatchSync(now()->addDay());

    // orphan should not been deleted
    assertDatabaseMissing('attachments', [
        'id' => $orphanAttachment->id,
    ]);

    // not orphan should not been deleted
    assertDatabaseHas('attachments', [
        'id' => $notOrphanAttachment->id,
    ]);
});
