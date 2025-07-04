<header style="background-color:white; border-bottom: 1px solid black;"  class="header header--mobile header--mobile-product" data-sticky="{{ theme_option('sticky_header_mobile_enabled', 'yes') == 'yes' ? 'true' : 'false' }}">
    <div class="navigation--mobile" >
        <div class="navigation__left">
            <a class="header__back" href="{{ route('public.products') }}"><i class="icon-chevron-left"></i><strong>{{ __('Back to Products') }}</strong></a>
        </div>
        @if (is_plugin_active('ecommerce'))
            <div class="navigation__right">
                <div class="header__actions">
                    <div class="ps-cart--mini">
                        <a class="header__extra btn-shopping-cart" href="{{ route('public.cart') }}">
                            <i class="icon-bag2"></i><span><i>{{ Cart::instance('cart')->count() }}</i></span>
                        </a>
                        <div class="ps-cart--mobile">
                            {!! Theme::partial('cart') !!}
                        </div>
                    </div>
                    <div class="ps-block--user-header">
                        <div class="ps-block__left"><a href="{{ route('customer.overview') }}"><i class="icon-user"></i></a></div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</header>
