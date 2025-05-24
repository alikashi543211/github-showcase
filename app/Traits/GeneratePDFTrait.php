<?php

namespace App\Traits;

use App\Models\Resume\ResumeEducationSectionsModel;
use App\Models\Resume\ResumeExperienceSectionsModel;
use App\Models\Resume\ResumeHeaderSectionsModel;
use App\Models\Resume\ResumeInterestSectionsModel;
use App\Models\Resume\ResumeLanguageSectionsModel;
use App\Models\Resume\ResumeLiveLinkSectionsModel;
use App\Models\Resume\ResumeProjectSectionsModel;
use App\Models\Resume\ResumeSkillSectionsModel;
use App\Rules\NoHtmlTags;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

trait GeneratePDFTrait
{
    private function make_HeaderSection_DataForPdf(&$data)
    {
        $data['headerSection'] = [];
        $userId = Auth::guard('admin')->user()->id;
        $activeJobPositionId = getActiveResumeJobPosition()->id ?? null;
        $headerSection = ResumeHeaderSectionsModel::where('job_position_id', $activeJobPositionId)
            ->where('created_by', $userId)
            ->where('is_active', 1)
            ->first();
        if ($headerSection) {
            $headerSection = (object) $headerSection->toArray();
            if (strpos($headerSection->short_summary, '{exp}') !== false) {
                $headerSection->short_summary = str_replace('{exp}', $headerSection->experience, $headerSection->short_summary);
            }
        }
        $data['headerSection'] = $headerSection ?? [];
    }

    private function make_SkillSection_DataForPdf(&$data)
    {
        $data['skillSection'] = [];
        $userId = Auth::guard('admin')->user()->id;
        $activeJobPositionId = getActiveResumeJobPosition()->id ?? null;
        $skillSection = ResumeSkillSectionsModel::select('skill_title', 'skill_icon')
            ->where('job_position_id', $activeJobPositionId)
            ->where('created_by', $userId)
            ->where('is_active', 1)
            ->orderBy('sort_number', 'ASC')
            ->get();
        $data['skillSection'] = $skillSection;
    }

    private function make_InterestSection_DataForPdf(&$data)
    {
        $data['interestSection'] = [];
        $userId = Auth::guard('admin')->user()->id;
        $activeJobPositionId = getActiveResumeJobPosition()->id ?? null;
        $interestSection = ResumeInterestSectionsModel::select('interest')
            ->where('job_position_id', $activeJobPositionId)
            ->where('created_by', $userId)
            ->where('is_active', 1)
            ->orderBy('sort_number', 'ASC')
            ->get()->toArray();
        $data['interestSection'] = $interestSection ?? [];
    }

    private function make_LanguageSection_DataForPdf(&$data)
    {
        $data['languageSection'] = [];
        $userId = Auth::guard('admin')->user()->id;
        $activeJobPositionId = getActiveResumeJobPosition()->id ?? null;
        $languageSection = ResumeLanguageSectionsModel::select('language_title', 'language_rating')
            ->where('job_position_id', $activeJobPositionId)
            ->where('created_by', $userId)
            ->where('is_active', 1)
            ->orderBy('sort_number', 'ASC')
            ->get()->toArray();
        $data['languageSection'] = $languageSection ?? [];
    }

    private function make_LiveLinks_DataForPdf(&$data)
    {
        $data['liveLinkSection'] = [];
        $userId = Auth::guard('admin')->user()->id;
        $activeJobPositionId = getActiveResumeJobPosition()->id ?? null;
        $liveLinkSection = ResumeLiveLinkSectionsModel::select('link_name', 'live_link', 'link_thumbnail')
            ->where('job_position_id', $activeJobPositionId)
            ->where('created_by', $userId)
            ->orderBy('sort_number', 'ASC')
            ->where('is_active', 1)->get();
        $data['liveLinkSection'] = $liveLinkSection;
        // dd($data['liveLinkSection']);
    }

    private function make_ExperienceSection_DataForPdf(&$data)
    {
        $data['experienceSection'] = [];
        $userId = Auth::guard('admin')->user()->id;
        $activeJobPositionId = getActiveResumeJobPosition()->id ?? null;
        $experienceSection = ResumeExperienceSectionsModel::where('job_position_id', $activeJobPositionId)
            ->where('created_by', $userId)
            ->orderBy('sort_number', 'ASC')
            ->where('is_active', 1)->with(['multipleDescriptions'])->get();
        $data['experienceSection'] = $experienceSection ?? [];
    }

    private function make_ProjectSection_DataForPdf(&$data)
    {
        $data['projectSection'] = [];
        $userId = Auth::guard('admin')->user()->id;
        $activeJobPositionId = getActiveResumeJobPosition()->id ?? null;
        $projectSection = ResumeProjectSectionsModel::where('job_position_id', $activeJobPositionId)
            ->where('created_by', $userId)
            ->orderBy('sort_number', 'ASC')
            ->where('is_active', 1)->get();
        $data['projectSection'] = $projectSection ?? [];
    }

    private function make_EducationSection_DataForPdf(&$data)
    {
        $data['educationSection'] = [];
        $userId = Auth::guard('admin')->user()->id;
        $activeJobPositionId = getActiveResumeJobPosition()->id ?? null;
        $educationSection = ResumeEducationSectionsModel::where('job_position_id', $activeJobPositionId)
            ->where('created_by', $userId)
            ->orderBy('sort_number', 'ASC')
            ->where('is_active', 1)->get();
        $data['educationSection'] = $educationSection ?? [];
    }

    private function transformAccordingType(&$data, $resumeType)
    {
        if ($resumeType == 'Business') {
            return true;
        }
        if (!isset($data['headerSection'])) {
            Log::error('Header Section does not exist....');
            return true;
        }
        if ($resumeType == 'Job') {
            $headerSection = $data['headerSection'];
            $headerSection->full_name = $headerSection->job_full_name ?? '';
            $headerSection->position_display_title = $headerSection->job_position_display_title ?? '';
            $headerSection->phone_number = $headerSection->job_phone_number ?? '';
            $headerSection->email = $headerSection->job_email ?? '';
            $headerSection->city = $headerSection->job_city ?? '';
            $headerSection->country = $headerSection->job_country ?? '';
            $headerSection->portfolio_website = $headerSection->job_portfolio_website ?? '';
            $headerSection->linked_in_link = $headerSection->job_linked_in_link ?? '';
            $headerSection->github_link = $headerSection->job_github_link ?? '';
            $data['headerSection'] = $headerSection;
            return true;
        }
        return true;
    }
}
