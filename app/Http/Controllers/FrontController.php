<?php

namespace App\Http\Controllers;

use App\Models\Resume\ResumeBuilderSettingsModel;
use App\Models\Resume\ResumeGithubSectionsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FrontController extends Controller
{
    public function index()
    {
        // Fetch all active GitHub projects from the database
        $github_projects = ResumeGithubSectionsModel::whereIsActive(1)->get();

        // Default wallpaper and profile image paths (fallbacks)

        // Fetch custom wallpaper and profile image paths from the settings table
        $settings = ResumeBuilderSettingsModel::where('key', 'LIKE', '%github_showcase_%')->pluck('value', 'key')->toArray();

        $settings['github_showcase_footer_copyright_text'] = str_replace('{current_year}', date('Y'), $settings['github_showcase_footer_copyright_text']);

        if (isset($settings['github_showcase_wallpaper_image_path']) && !empty($settings['github_showcase_wallpaper_image_path'])) {
            $settings['github_showcase_wallpaper_image_path'] = env('RESUME_BASE_MEDIA_URL') . $settings['github_showcase_wallpaper_image_path'];
        }
        if (isset($settings['github_showcase_profile_image_path']) && !empty($settings['github_showcase_profile_image_path'])) {
            $settings['github_showcase_profile_image_path'] = env('RESUME_BASE_MEDIA_URL') . $settings['github_showcase_profile_image_path'];
        }

        // Return the front.index view with all defined variables in the current scope
        return view('front.index', get_defined_vars());
    }
}
