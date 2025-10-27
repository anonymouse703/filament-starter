<?php

namespace App\Services\FileUploader\Uploaders;

use App\Models\Member;
use App\Services\FileUploader\Facades\FileUploader;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class MemberApiProfileUploader
{
    protected ?Member $member;
    protected UploadedFile $uploadedFile;
    protected string $storagePath = 'members';
    protected bool $generateThumbnail = false;

    public function __construct(UploadedFile $uploadedFile, Member $member)
    {
        $this->uploadedFile = $uploadedFile;
        $this->member = $member;
    }

    public static function uploadPhoto(UploadedFile $uploadedFile, Member $member): int
    {
        $seriesUploader = new self($uploadedFile, $member);
        $seriesUploader->storagePath = 'member_photos';
        $seriesUploader->generateThumbnail = true;
        return $seriesUploader->upload();
    }

    protected function upload(): int
    {
        $file = FileUploader::upload($this->uploadedFile)
            ->uploader($this->member)
            ->storagePath($this->storagePath)
            ->fileName(Str::random(8));

        if ($this->generateThumbnail) {
            $file->generateThumbnail(300, 300);
        }

        return $file->getFile()->id;
    }

}
