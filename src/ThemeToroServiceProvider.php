<?php

namespace Ophim\ThemeToro;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class ThemeToroServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->setupDefaultThemeCustomizer();
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'themes');

        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('themes/toro')
        ], 'toro-assets');
    }

    protected function setupDefaultThemeCustomizer()
    {
        config(['themes' => array_merge(config('themes', []), [
            'toro' => [
                'name' => 'Theme Toro',
                'author' => 'opdlnf01@gmail.com',
                'package_name' => 'ophimcms/theme-toro',
                'publishes' => ['toro-assets'],
                'preview_image' => '',
                'options' => [
                    [
                        'name' => 'per_page_limit',
                        'label' => 'Pages limit',
                        'type' => 'number',
                        'value' => 40,
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-6',
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'movie_related_limit',
                        'label' => 'Movies related limit',
                        'type' => 'number',
                        'value' => 16,
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-6',
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'home_page_slider_poster',
                        'label' => 'Home page slider poster',
                        'type' => 'text',
                        'hint' => 'Label|relation|find_by_field|value|sort_by_field|sort_algo|limit',
                        'value' => 'Phim đề cử||is_recommended|1|updated_at|desc|10',
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'home_page_slider_thumb',
                        'label' => 'Home page slider thumb',
                        'type' => 'text',
                        'hint' => 'Label|relation|find_by_field|value|sort_by_field|sort_algo|limit',
                        'value' => 'Phim mới cập nhật||is_copyright|0|updated_at|desc|24',
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'latest',
                        'label' => 'Home Page Main',
                        'type' => 'code',
                        'hint' => 'display_label|relation|find_by_field|value|sort_by_field|sort_algo|limit|show_more_url|show_template (section_thumb|section_poster)',
                        'value' => <<<EOT
                        Phim chiếu rạp mới||is_shown_in_theater|1|created_at|desc|6|/danh-sach/phim-chieu-rap|section_poster
                        Phim bộ mới||type|series|updated_at|desc|16|/danh-sach/phim-bo|section_thumb
                        Phim lẻ mới||type|single|updated_at|desc|16|/danh-sach/phim-le|section_thumb
                        Phim hoạt hình mới|categories|slug|hoat-hinh|updated_at|desc|12|/the-loai/hoat-hinh|section_poster
                        EOT,
                        'attributes' => [
                            'rows' => 5
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'hotest',
                        'label' => 'Rightbar',
                        'type' => 'code',
                        'hint' => 'Label|relation|find_by_field|value|sort_by_field|sort_algo|limit|show_template (rightbar_text|rightbar_thumb|rightbar_thumb_2)',
                        'value' => <<<EOT
                        Sắp chiếu||status|trailer|publish_year|desc|5|rightbar_text
                        Top phim lẻ||type|single|view_week|desc|5|rightbar_thumb
                        Top phim bộ||type|series|view_week|desc|6|rightbar_thumb_2
                        EOT,
                        'attributes' => [
                            'rows' => 5
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'additional_css',
                        'label' => 'Additional CSS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom CSS'
                    ],
                    [
                        'name' => 'body_attributes',
                        'label' => 'Body attributes',
                        'type' => 'text',
                        'value' => 'id="Tf-Wp" class="home blog BdGradient"',
                        'tab' => 'Custom CSS'
                    ],
                    [
                        'name' => 'additional_header_js',
                        'label' => 'Header JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'additional_body_js',
                        'label' => 'Body JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'additional_footer_js',
                        'label' => 'Footer JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'footer',
                        'label' => 'Footer',
                        'type' => 'code',
                        'value' => <<<EOT
                            <footer class="Footer">
                                <div class="Bot">
                                    <div class="Container">
                                        <p>Toroflix is the evolution of toroplay, we put the best of us in this theme that you love, we
                                            promise</p>
                                    </div>
                                </div>
                            </footer>
                        EOT,
                        'tab' => 'Custom HTML'
                    ],
                    [
                        'name' => 'ads_header',
                        'label' => 'Ads header',
                        'type' => 'code',
                        'value' => <<<EOT

                        EOT,
                        'tab' => 'Ads'
                    ],
                    [
                        'name' => 'ads_catfish',
                        'label' => 'Ads catfish',
                        'type' => 'code',
                        'value' => <<<EOT

                        EOT,
                        'tab' => 'Ads'
                    ]
                ],
            ]
        ])]);
    }
}
