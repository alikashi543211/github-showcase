<?php

namespace App\Models\Resume;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;

class ResumeExperienceSectionsModel extends Model
{
    use HasFactory, SoftDeletes;
    // use \OwenIt\Auditing\Auditable;

    protected $table = 'resume_experience_sections';

    public function getCompanyLogoAttribute($value)
    {
        if(isset($value))
        {
            if(File::exists(public_path($value))){
                return url($value);
            }
        }
        return gallery_photo('empty.png', 'avatars');
    }

    public function multipleDescriptions()
    {
        return $this->hasMany(ResumeExperienceSectionDescriptionsModel::class, 'resume_experience_section_id', 'id')->whereNotNull('description')->orderBy('sort_number', 'ASC');
    }
}
