<?php

namespace Botble\Marketplace\Http\Controllers;

use Botble\Base\Facades\Assets;
use Botble\Base\Widgets\Contracts\AdminWidget;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Marketplace\Tables\RecentWithdrawalsTable;
use Botble\Marketplace\Tables\StoreRevenueTable;
use Illuminate\Http\Request;

class ReportController extends BaseController
{
    public function index(
        Request $request,
        AdminWidget $widget
    ) {
        $this->pageTitle(trans('plugins/marketplace::marketplace.reports.name'));

        Assets::usingVueJS()
            ->addScriptsDirectly([
                'vendor/core/plugins/ecommerce/libraries/daterangepicker/daterangepicker.js',
                'vendor/core/plugins/ecommerce/js/report.js',
            ])
            ->addStylesDirectly([
                'vendor/core/plugins/ecommerce/libraries/daterangepicker/daterangepicker.css',
                'vendor/core/plugins/ecommerce/css/report.css',
            ])
            ->addScripts(['moment', 'apexchart'])
            ->addStyles(['apexchart']);

        [$startDate, $endDate] = EcommerceHelper::getDateRangeInReport($request);

        if ($request->ajax()) {
            return $this
                ->httpResponse()
                ->setData($widget->render(MARKETPLACE_MODULE_SCREEN_NAME));
        }

        return view(
            'plugins/marketplace::reports.index',
            compact('startDate', 'endDate', 'widget')
        );
    }

    public function getStoreRevenues(StoreRevenueTable $storeRevenueTable)
    {
        return $storeRevenueTable->renderTable();
    }

    public function getRecentWithdrawals(RecentWithdrawalsTable $recentWithdrawalsTable)
    {
        return $recentWithdrawalsTable->renderTable();
    }
}
