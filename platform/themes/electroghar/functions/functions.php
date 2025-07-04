<?php

use Botble\Ads\Facades\AdsManager;
use Botble\Base\Facades\EmailHandler;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Ecommerce\Facades\FlashSale;
use Botble\Ecommerce\Supports\FlashSaleSupport;
use Botble\Media\Facades\RvMedia;
use Botble\Theme\Facades\Theme;
use Botble\Theme\Supports\ThemeSupport;

register_page_template([
    'blog-sidebar' => __('Blog Sidebar'),
    'full-width' => __('Full width'),
    'homepage' => __('Homepage'),
    'coming-soon' => __('Coming soon'),
]);

register_sidebar([
    'id' => 'footer_sidebar',
    'name' => __('Footer sidebar'),
    'description' => __('Widgets in footer of page'),
]);

register_sidebar([
    'id' => 'bottom_footer_sidebar',
    'name' => __('Bottom Footer sidebar'),
    'description' => __('Widgets in bottom footer'),
]);

app()->booted(function (): void {
    ThemeSupport::registerSocialLinks();
    ThemeSupport::registerSocialSharing();
    ThemeSupport::registerSiteLogoHeight(40);
    ThemeSupport::registerSiteCopyright();
    ThemeSupport::registerLazyLoadImages();
    ThemeSupport::registerToastNotification();

    if (is_plugin_active('ecommerce')) {
        if (method_exists(FlashSaleSupport::class, 'addShowSaleCountLeftSetting')) {
            FlashSale::addShowSaleCountLeftSetting();
        }

        EcommerceHelper::registerProductGalleryOptions();
        EcommerceHelper::registerProductVideo();
    }

    RvMedia::addSize('medium', 790, 510)
        ->addSize('small', 300, 300);

    add_action('init', function (): void {
        EmailHandler::addTemplateSettings(Theme::getThemeName(), [
            'name' => __('Theme emails'),
            'description' => __('Config email templates for theme'),
            'templates' => [
                'download_app' => [
                    'title' => __('Download apps'),
                    'description' => __('Send mail with links to download apps'),
                    'subject' => __('Download apps'),
                    'can_off' => true,
                ],
            ],
            'variables' => [],
        ], 'themes');
    }, 125);

    if (is_plugin_active('ads')) {
        AdsManager::registerLocation('top-slider-image-1', __('Top Slider Image 1 (deprecated)'))
            ->registerLocation('top-slider-image-2', __('Top Slider Image 2 (deprecated)'))
            ->registerLocation('product-sidebar', __('Product sidebar'));
    }
});
