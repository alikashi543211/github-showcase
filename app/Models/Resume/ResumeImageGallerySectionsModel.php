<?php

namespace App\Models\Resume;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;

class ResumeImageGallerySectionsModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'resume_image_gallery_sections';

    public function getImagePathAttribute($value)
    {
        if (isset($value)) {
            if (File::exists(public_path($value))) {
                return url($value);
            }
        }
        return gallery_photo('empty.png', 'avatars');
    }

    public function getImageTitleAttribute($value)
    {
        if (!(isset($value) && !empty($value))) {
            return explode('.', basename($this->image_path))[0];
        }
        return $value;
    }
}
