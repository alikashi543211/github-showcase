<?php

namespace App\Models\Resume;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResumeGithubSectionsModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'resume_github_sections';
}
