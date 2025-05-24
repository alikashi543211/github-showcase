<?php

namespace App\Models\Resume;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;

class ResumeSkillSectionsModel extends Model
{
    use HasFactory, SoftDeletes;
    // use \OwenIt\Auditing\Auditable;

    protected $table = 'resume_skill_sections';

    public function getSkilliconAttribute($value)
    {
        if(isset($value))
        {
            if(File::exists(public_path($value))){
                return url($value);
            }
        }
        return gallery_photo('empty.png', 'avatars');
    }
}
