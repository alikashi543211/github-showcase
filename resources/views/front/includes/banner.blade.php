<!-- Top section: Wallpaper background and profile display picture -->
<div class="wallpaper-dp-box">
    <div class="wallpaper-image">
        @if (isset($settings['is_github_showcase_profile_image_path']) &&
                $settings['is_github_showcase_profile_image_path'] == 'Yes')
            <div class="dp-image">
                <img src="{{ $settings['github_showcase_profile_image_path'] ?? asset('assets/images/blank.png') }}"
                    alt="Kashif DP">
            </div>
        @endif
    </div>
</div>
