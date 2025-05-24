<?php

namespace App\Models\Resume;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;

class ResumeChatgptSectionsModel extends Model
{
    protected $table = 'resume_chatgpt_sections';

    use HasFactory, SoftDeletes;

    public function getDocumentPathAttribute($value)
    {
        if (isset($value)) {
            if (File::exists(public_path($value))) {
                return url($value);
            }
        }
        return gallery_photo('empty.png', 'avatars');
    }
}
