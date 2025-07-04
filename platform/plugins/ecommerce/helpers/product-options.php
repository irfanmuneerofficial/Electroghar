<?php

use Botble\Base\Facades\Html;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Ecommerce\Models\Product;
use Botble\Theme\Facades\Theme;
use Illuminate\Support\Facades\Log;

if (! function_exists('render_product_options')) {
    function render_product_options(Product $product): string
    {
        if (! EcommerceHelper::isEnabledProductOptions()) {
            return '';
        }

        $product->loadMissing(['options', 'options.values']);

        if (! $product->options) {
            return '';
        }

        $html = '<div class="pr_switch_wrap" id="product-option">';

        $script = 'vendor/core/plugins/ecommerce/js/change-product-options.js';
        $style = 'vendor/core/plugins/ecommerce/css/front-ecommerce.css';

        $version = EcommerceHelper::getAssetVersion();

        Theme::asset()->add('front-ecommerce-css', $style, version: $version);
        Theme::asset()->container('footer')->add('change-product-options', $script, ['jquery'], version: $version);

        foreach ($product->options as $option) {
            $typeClass = __NAMESPACE__ . '\\' . $option->option_type;
            if (class_exists($typeClass)) {
                $instance = new $typeClass();
                $html .= $instance->setOption($option)->setProduct($product)->render();
            } else {
                Log::error(sprintf('Class %s not found', $typeClass));
            }
        }

        $html .= '</div>';

        if (! request()->ajax()) {
            return $html;
        }

        return $html . Html::style($style)->toHtml() . Html::script($script)->toHtml();
    }
}

if (! function_exists('render_product_options_info')) {
    function render_product_options_info(array $productOptions, ?Product $product, bool $displayBasePrice = false): string
    {
        if (! EcommerceHelper::isEnabledProductOptions()) {
            return '';
        }

        return view(EcommerceHelper::viewPath('options.render-options-info'), compact('productOptions', 'product', 'displayBasePrice'))->render();
    }
}

if (! function_exists('render_product_options_html')) {
    function render_product_options_html(array $productOptions, ?float $basePrice = null, bool $displayBasePrice = true): string
    {
        if (! EcommerceHelper::isEnabledProductOptions()) {
            return '';
        }

        return view(EcommerceHelper::viewPath('options.render-options-html'), compact('productOptions', 'displayBasePrice', 'basePrice'))->render();
    }
}
