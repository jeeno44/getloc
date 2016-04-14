<?php

namespace App\Widgets;

class AdminLeftMenu
{
    public function run()
    {
        $currentUri = \Route::getCurrentRoute()->getPath();
        $items = $this->build();

        return view('admin.widgets.left_menu')
            ->with('adminMenuItems', $items)
            ->with('currentUri', $currentUri);
    }

    function build()
    {
        $items = [
            'Пользователи' => [
                'icon'  => 'si si-users',
                'uri'   => 'admin/users',
                'items' => [

                    'Пользователи' => [
                        'icon'  => 'si si-users',
                        'uri'   => 'admin/users',
                    ],

                    'Партнеры' => [
                        'icon'  => 'si si-briefcase',
                        'uri'   => 'admin/users/partners',
                    ],
                ]
            ],
            'Обратная связь' => [
                'icon'  => 'si si-envelope',
                'uri'   => 'admin/feedback',
                'items' => [

                    'Оповещение' => [
                        'icon'  => 'fa fa-mail-reply',
                        'uri'   => 'admin/feedback/call',
                    ],

                    'Запрос демо' => [
                        'icon'  => 'si si-rocket',
                        'uri'   => 'admin/feedback/demo',
                    ],

                    'Индивидуальные условия' => [
                        'icon'  => 'fa fa-percent',
                        'uri'   => 'admin/feedback/individual',
                    ],
                ]
            ],
            'Биллинг' => [
                'icon'  => 'fa fa-money',
                'uri'   => 'admin/billing',
                'items' => [

                    'Тарифные планы' => [
                        'icon'  => 'si si-equalizer',
                        'uri'   => 'admin/billing/plans',
                    ],

                    'Подписки' => [
                        'icon'  => 'fa fa-shopping-cart',
                        'uri'   => 'admin/billing/subscriptions',
                    ],

                    'Платежи' => [
                        'icon'  => 'fa fa-history',
                        'uri'   => 'admin/billing/payments',
                    ],

                    'Заказы переводов' => [
                        'icon'  => 'fa fa-globe',
                        'uri'   => 'admin/billing/orders',
                    ],

                    'Купоны' => [
                        'icon'  => 'fa fa-money',
                        'uri'   => 'admin/billing/coupons',
                    ],
                ]
            ],
            'Система' => [
                'icon'  => 'fa fa-cog',
                'uri'   => 'admin/settings',
                'items' => [

                    'Настройки' => [
                        'icon'  => 'fa fa-cog',
                        'uri'   => 'admin/settings',
                    ],

                    'Стоп-лист ресурсов' => [
                        'icon'  => 'fa fa-warning',
                        'uri'   => 'admin/settings/stop',
                    ],

                    'Языки' => [
                        'icon'  => 'fa fa-language',
                        'uri'   => 'admin/settings/languages',
                    ],
                ]
            ],
        ];

        return $items;
    }
}