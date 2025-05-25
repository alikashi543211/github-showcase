<!-- Footer Section -->
@if (isset($settings['is_github_showcase_footer_show_hide']) &&
        $settings['is_github_showcase_footer_show_hide'] == 'Yes')
    <footer class="bg-light border-top py-4">
        <div class="container text-center">
            <p class="mb-2 text-muted fw-semibold mb-1">
                {!! $settings['github_showcase_footer_copyright_text'] ?? '-----' !!}
            </p>
            <a href="{{ $settings['github_showcase_footer_website_link_text'] ?? '#' }}" target="_blank"
                class="text-primary text-decoration-none fw-medium">
                {{ $settings['github_showcase_footer_website_link_text'] ?? '-----' }}
            </a>
        </div>
    </footer>
@endif
