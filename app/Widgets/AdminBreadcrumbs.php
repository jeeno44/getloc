<?php

namespace App\Widgets;

use App\Breadcrumbs;

class AdminBreadcrumbs
{
    public function run()
    {
        $crumbs = Breadcrumbs::getInstance()->getCrumbs();
        return view('admin.widgets.breadcrumbs')
            ->with('breadcrumbs', $crumbs);
    }
}