<?php

namespace App\Models\Resume;

use App\Models\Resume\ResumeSkillSectionsModel;
use Illuminate\Database\Eloquent\Model;

class ResumeGithubSectionUsedTechnologiesModel extends Model
{
    protected $table = "resume_github_section_used_technologies";

    public function skill()
    {
        return $this->belongsTo(ResumeSkillSectionsModel::class, 'resume_skill_section_id', 'id');
    }
}
