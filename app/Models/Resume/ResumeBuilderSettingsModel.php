<?php

namespace App\Models\Resume;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class ResumeBuilderSettingsModel extends Model
{
    protected $table = "resume_builder_settings";

    public function getValueAttribute($value)
    {
        if ($this->is_file == true) {
            if (File::exists(env('BASE_MEDIA_PATH') . $value)) {
                return env('BASE_MEDIA_URL') . $value;
            }
            return null;
        }
        return $value;
    }
}
