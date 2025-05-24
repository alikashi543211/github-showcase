<?php

namespace App\Models\Resume;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;

class ResumeProjectSectionsModel extends Model
{
    use HasFactory, SoftDeletes;
    // use \OwenIt\Auditing\Auditable;

    protected $table = 'resume_project_sections';

    /**
     * Get the companyExperience that owns the ResumeProjectSectionsModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function companyExperience(): BelongsTo
    {
        return $this->belongsTo(ResumeExperienceSectionsModel::class, 'resume_experience_section_id', 'id');
    }

    public function getProjectThumbnailAttribute($value)
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
