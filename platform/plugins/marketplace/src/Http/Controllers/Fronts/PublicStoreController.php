<?php

namespace Botble\Marketplace\Http\Controllers\Fronts;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Facades\BaseHelper;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Ecommerce\Services\Products\GetProductService;
use Botble\Marketplace\Facades\MarketplaceHelper;
use Botble\Marketplace\Forms\ContactStoreForm;
use Botble\Marketplace\Http\Requests\Fronts\CheckStoreUrlRequest;
use Botble\Marketplace\Models\Store;
use Botble\Media\Facades\RvMedia;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\SeoHelper\SeoOpenGraph;
use Botble\Slug\Facades\SlugHelper;
use Botble\Theme\Facades\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PublicStoreController extends BaseController
{
    public function getStores(Request $request)
    {
        Theme::breadcrumb()
            ->add(__('Stores'), route('public.stores'));

        SeoHelper::setTitle(__('Stores'))->setDescription(__('Stores'));

        $condition = [];

        $search = BaseHelper::stringify(BaseHelper::clean($request->input('q')));
        if ($search) {
            $condition[] = ['name', 'LIKE', '%' . $search . '%'];
        }

        $with = ['slugable'];
        if (EcommerceHelper::isReviewEnabled()) {
            $with['reviews'] = function ($query): void {
                $query->where([
                    'ec_products.status' => BaseStatusEnum::PUBLISHED,
                    'ec_reviews.status' => BaseStatusEnum::PUBLISHED,
                ]);
            };
        }

        $stores = Store::query()
            ->wherePublished()
            ->where($condition)
            ->with($with)
            ->withCount([
                'products' => function ($query): void {
                    $query
                        ->where('is_variation', 0)
                        ->wherePublished();
                },
            ])->latest()
            ->paginate(12);

        return Theme::scope('marketplace.stores', compact('stores'), MarketplaceHelper::viewPath('stores', false))->render();
    }

    public function getStore(
        string $key,
        Request $request,
        GetProductService $productService
    ) {
        $slug = SlugHelper::getSlug($key, SlugHelper::getPrefix(Store::class));

        abort_unless($slug, 404);

        $condition = [
            'mp_stores.id' => $slug->reference_id,
            'mp_stores.status' => BaseStatusEnum::PUBLISHED,
        ];

        if (Auth::check() && $request->input('preview')) {
            Arr::forget($condition, 'status');
        }

        $store = Store::query()
            ->wherePublished()
            ->with(['slugable', 'metadata'])
            ->where($condition)
            ->firstOrFail();

        if ($store->slugable->key !== $slug->key) {
            return redirect()->to($store->url);
        }

        SeoHelper::setTitle($store->name)->setDescription($store->description);

        $meta = new SeoOpenGraph();

        if ($store->logo) {
            $meta->setImage(RvMedia::getImageUrl($store->logo));
        }
        $meta->setDescription($store->description);
        $meta->setUrl($store->url);
        $meta->setTitle($store->name);

        SeoHelper::setSeoOpenGraph($meta);

        Theme::breadcrumb()
            ->add(__('Stores'), route('public.stores'))
            ->add($store->name, $store->url);

        $with = EcommerceHelper::withProductEagerLoadingRelations();

        $products = $productService->getProduct(
            $request,
            null,
            null,
            $with,
            [],
            ['is_variation' => 0, 'store_id' => $store->getKey()]
        );

        if ($request->ajax()) {
            $total = $products->total();
            $message = $total > 1 ? __(':total Products found', compact('total')) : __(
                ':total Product found',
                compact('total')
            );

            $view = Theme::getThemeNamespace('views.marketplace.stores.items');

            if (! view()->exists($view)) {
                $view = MarketplaceHelper::viewPath('stores.items', false);
            }

            return $this
                ->httpResponse()
                ->setData(view($view, compact('products', 'store'))->render())
                ->setMessage($message);
        }

        if (function_exists('admin_bar')) {
            admin_bar()
                ->registerLink(
                    trans('plugins/marketplace::store.edit_this_store'),
                    route('marketplace.store.edit', $store->getKey()),
                    null,
                    'marketplace.store.edit'
                );
        }

        $contactForm = ContactStoreForm::createFromArray(['id' => $store->getKey()]);

        return Theme::scope(
            'marketplace.store',
            compact('store', 'products', 'contactForm'),
            MarketplaceHelper::viewPath('store', false)
        )->render();
    }

    public function checkStoreUrl(CheckStoreUrlRequest $request)
    {
        abort_unless($request->ajax(), 404);

        $slug = $request->input('url');
        $slug = Str::slug($slug, '-', ! SlugHelper::turnOffAutomaticUrlTranslationIntoLatin() ? 'en' : false);

        $existing = SlugHelper::getSlug($slug, SlugHelper::getPrefix(Store::class));

        $this->httpResponse()->setData(['slug' => $slug]);

        if ($existing && $existing->reference_id != $request->input('reference_id')) {
            return $this->httpResponse()
                ->setError()
                ->setMessage(__('Not Available'));
        }

        return $this->httpResponse()->setMessage(__('Available'));
    }
}
