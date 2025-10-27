<?php

namespace App\Services\FileUploader\Uploaders;

use App\Models\User;
use App\Services\FileUploader\Facades\FileUploader;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class UserFileUploader
{
    protected ?User $user;
    protected UploadedFile $uploadedFile;
    protected string $storagePath = 'users';
    protected bool $generateThumbnail = true;

    public function __construct(UploadedFile $uploadedFile, User $user)
    {
        $this->uploadedFile = $uploadedFile;
        $this->user = $user;
    }

    public static function uploadPhoto(UploadedFile $uploadedFile, User $user): int
    {
        $userProfileUploader = new self($uploadedFile, $user);
        $userProfileUploader->storagePath = 'users_photos';
        $userProfileUploader->generateThumbnail = true;
        return $userProfileUploader->upload();
    }

    protected function upload(): int
    {
        $file = FileUploader::upload($this->uploadedFile)
            ->uploader($this->user)
            ->storagePath($this->storagePath)
            ->fileName(Str::random(8));

        if ($this->generateThumbnail) {
            $file->generateThumbnail(300, 300);
        }

        return $file->getFile()->id;
    }

}
