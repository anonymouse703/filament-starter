<?php

namespace App\Services\FileUploader;

use App\Enums\File\Disk;
use App\Models\File;
use Exception;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ThumbnailGenerator
{
    protected string $fileDir = 'images/thumbnails';
    protected Disk $disk;

    public function __construct(protected File $file)
    {
        $this->fileDir = app()->environment() . '/' . $this->fileDir;

        $this->disk = $this->file?->disk ?
            Disk::from($this->file->disk) : Disk::from(config('filesystems.default'));
    }

    public function generate(int $width, int $height): bool
    {
        try {
            $name = pathinfo($this->file->path, PATHINFO_FILENAME);

            $image = Storage::disk($this->disk->value)->get($this->file->path);
            $manager = new ImageManager(new Driver());
            $thumbnail = $manager->read($image)->scale($width, $height);
            $path = $this->fileDir . '/' . $name . '_thumb.png';
            Storage::disk($this->disk->value)->put($path, (string) $thumbnail->encode(), 'public');

            $this->file->thumbnail_path = $path;
            $this->file->save();
        } catch (Exception $e) {
            report($e);
            return false;
        }

        return true;
    }

    public function setDisk(Disk $disk): static
    {
        $this->disk = $disk;

        return $this;
    }
}
