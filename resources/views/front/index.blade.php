<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GitHub Project Showcase - KashifTech</title>

    <!-- Bootstrap CSS for responsive layout and styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/custom.css">
    <style>
        /* Wallpaper background styling */
        .wallpaper-image {
            height: 200px;
            background: black url("{{ $settings['github_showcase_wallpaper_image_path'] ?? '' }}") no-repeat center;
            background-size: cover;
            border-radius: 12px;
        }
    </style>
</head>

<body>

    <div class="container py-3">
        @include('front.includes.banner')

        <!-- Section heading -->
        <h1 class="text-center section-title">
            {{ $settings['github_showcase_heading_text'] ?? '-----' }}</h1>

        <!-- Project Cards Section -->
        <div class="row g-4 mb-5">
            @if ($github_projects->isNotEmpty())
                <!-- Loop through each GitHub project and display in a card -->
                @foreach ($github_projects as $project)
                    <div class="col-md-6 col-lg-4">
                        <div class="card project-card h-100 shadow-sm">
                            <div class="card-body d-flex flex-column">
                                <!-- Project title -->
                                <h5 class="card-title">{{ $project->github_title }}</h5>

                                <!-- Project description -->
                                <p class="card-text flex-grow-1">
                                    {{ \Illuminate\Support\Str::limit($project->github_description ?: 'Description not available.', 200, '...') }}
                                </p>

                                <!-- Technologies used badges -->
                                <div class="mb-2">
                                    @if (!empty($project->usedTechnologies))
                                        @foreach ($project->usedTechnologies as $tech)
                                            <span
                                                class="badge tech-badge">{{ $tech->skill->skill_title ?? '-----' }}</span>
                                        @endforeach
                                    @endif
                                </div>

                                <!-- GitHub repo link button -->
                                @if (!empty($project->github_repo_url))
                                    <a href="{{ $project->github_repo_url }}" target="_blank"
                                        class="btn btn-sm btn-dark mt-2">View on GitHub</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                @include('front.includes.empty_projects')
            @endif
        </div>
    </div>


    @include('front.includes.footer')
</body>

</html>
