<?php

namespace App\Http\Controllers;

use App\Models\Resume\ResumeGithubSectionsModel;
use App\Resume\ResumeSettingSection;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        // Fetch all active GitHub projects from the database
        $github_projects = ResumeGithubSectionsModel::whereIsActive(1)->get();

        // Default wallpaper and profile image paths (fallbacks)
        $wallpaper_image = asset('assets/images/Github-Showcase-WallPaper.png');
        $profile_image = asset('assets/images/kashif-dp.png');

        // Fetch custom wallpaper and profile image paths from the settings table
        $wallpaper_image_db = ResumeSettingSection::whereKey('github_showcase_wallpaper_image_path')->first();
        $profile_image_db = ResumeSettingSection::whereKey('github_showcase_profile_image_path')->first();

        // If a custom wallpaper image is found in the DB, use it instead of the default
        if (isset($wallpaper_image_db) && !empty($wallpaper_image_db)) {
            $wallpaper_image = env('BASE_MEDIA_URL') . $wallpaper_image_db->value;
        }

        // If a custom profile image is found in the DB, use it instead of the default
        if (isset($profile_image_db) && !empty($profile_image_db)) {
            $profile_image = env('BASE_MEDIA_URL') . $profile_image_db->value;
        }

        // Return the front.index view with all defined variables in the current scope
        return view('front.index', get_defined_vars());
    }
}
