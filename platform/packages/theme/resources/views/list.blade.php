@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div class="row row-cards mb-5">
        @foreach ($themes as $key => $theme)
            <div class="col-12 col-sm-6 col-lg-4">
                <x-core::card>
                    @if ($inherit = Arr::get($theme, 'inherit'))
                        <div class="ribbon bg-red">
                            {{ trans('packages/theme::theme.child_of', ['theme' => Arr::get($themes, $inherit . '.name', $inherit)]) }}
                        </div>
                    @endif


                    <x-core::card.body>
                        <h4 class="card-title text-truncate mb-2" title="{{ $theme['name'] }}">
                            {{ $theme['name'] }}
                        </h4>
                        @if (! empty($theme['description']))
                            <p class="text-secondary text-truncate" title="{{ $theme['description'] }}">
                                {{ $theme['description'] }}
                            </p>
                        @endif

                    
                    </x-core::card.body>

                    <x-core::card.footer>
                        <div class="btn-list">
                            @if (setting('theme') && Theme::getThemeName() == $key)
                                <x-core::button
                                    type="button"
                                    color="info"
                                    :disabled="true"
                                    icon="ti ti-check"
                                >
                                    {{ trans('packages/theme::theme.activated') }}
                                </x-core::button>
                            @else
                                @if (Auth::guard()->user()->hasPermission('theme.activate'))
                                    <x-core::button
                                        type="button"
                                        color="primary"
                                        icon="ti ti-check"
                                        class="btn-trigger-active-theme"
                                        :data-url="route('theme.active', ['theme' => $key])"
                                        data-theme="{{ $key }}"
                                    >
                                        {{ trans('packages/theme::theme.active') }}
                                    </x-core::button>
                                @endif
                                @if (Auth::guard()->user()->hasPermission('theme.remove'))
                                    <x-core::button
                                        type="button"
                                        icon="ti ti-trash"
                                        class="btn-trigger-remove-theme"
                                        :data-url="route('theme.remove', ['theme' => $key])"
                                        data-theme="{{ $key }}"
                                    >
                                        {{ trans('packages/theme::theme.remove') }}
                                    </x-core::button>
                                @endif
                            @endif
                        </div>
                    </x-core::card.footer>
                </x-core::card>
            </div>
        @endforeach
    </div>
@stop

@push('footer')
    <x-core::modal.action
        id="remove-theme-modal"
        type="danger"
        :title="trans('packages/theme::theme.remove_theme')"
        :description="trans('packages/theme::theme.remove_theme_confirm_message')"
        :submit-button-attrs="['id' => 'confirm-remove-theme-button']"
        :submit-button-label="trans('packages/theme::theme.remove_theme_confirm_yes')"
    />
@endpush
