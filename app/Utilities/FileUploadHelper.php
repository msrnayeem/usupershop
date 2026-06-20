<?php

namespace App\Utilities;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class FileUploadHelper
{
    const ALLOWED_MIME  = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    const ALLOWED_EXT   = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    const MAX_SIZE_KB   = 5120;

    /**
     * Securely validate and save an uploaded image.
     * Returns sanitized filename or null on failure.
     */
    public static function saveImage(UploadedFile $file, string $directory, ?string $oldFile = null): ?string
    {
        $mime = $file->getMimeType();
        if (!in_array($mime, self::ALLOWED_MIME)) {
            Log::warning('FileUpload: Rejected MIME ' . $mime);
            return null;
        }

        $ext = strtolower($file->getClientOriginalExtension());
        if (!in_array($ext, self::ALLOWED_EXT)) {
            Log::warning('FileUpload: Rejected extension ' . $ext);
            return null;
        }

        if ($file->getSize() > self::MAX_SIZE_KB * 1024) {
            return null;
        }

        // Random secure filename - never trust original name
        $filename = date('YmdHis') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;

        // Delete old file safely
        if ($oldFile) {
            $oldPath = public_path($directory . '/' . basename($oldFile));
            if (file_exists($oldPath) && is_file($oldPath)) {
                @unlink($oldPath);
            }
        }

        $file->move(public_path($directory), $filename);
        return $filename;
    }
}
