<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('guest-layout', \App\View\Components\Layouts\GuestLayout::class);
        Blade::component('auth-layout', \App\View\Components\Layouts\AuthLayout::class);

        Blade::component('admin.guest-layout', \App\View\Components\Admin\GuestLayout::class);
        Blade::component('admin.auth-layout', \App\View\Components\Admin\AuthLayout::class);
        Blade::component('admin.table-container', \App\View\Components\Admin\TableContainer::class);
        Blade::component('admin.table', \App\View\Components\Admin\Table::class);
        Blade::component('admin.thead', \App\View\Components\Admin\Thead::class);
        Blade::component('admin.tbody', \App\View\Components\Admin\Tbody::class);
        Blade::component('admin.tr', \App\View\Components\Admin\Tr::class);
        Blade::component('admin.th', \App\View\Components\Admin\Th::class);
        Blade::component('admin.td', \App\View\Components\Admin\Td::class);
        Blade::component('admin.row', \App\View\Components\Admin\Row::class);
        Blade::component('admin.row-container', \App\View\Components\Admin\RowContainer::class);
        Blade::component('admin.anchor', \App\View\Components\Admin\Anchor::class);
        Blade::component('admin.button', \App\View\Components\Admin\Button::class);
        Blade::component('admin.edit-form', \App\View\Components\Admin\EditForm::class);
        Blade::component('admin.edit-form-row', \App\View\Components\Admin\EditFormRow::class);

        Blade::component('admin.form.input', \App\View\Components\Admin\Form\Input::class);
        Blade::component('admin.form.textarea', \App\View\Components\Admin\Form\Textarea::class);
        Blade::component('admin.media-upload', \App\View\Components\Admin\MediaUpload::class);

        Blade::component('admin.content-status-badge', \App\View\Components\Admin\ContentStatusBadge::class);
        Blade::component('admin.publish-level-enum', \App\View\Components\Admin\PublishLevelEnum::class);
        Blade::component('admin.site-enum', \App\View\Components\Admin\SiteEnum::class);
        Blade::component('admin.contents-map', \App\View\Components\Admin\ContentsMap::class);
    }
}
