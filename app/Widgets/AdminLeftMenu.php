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
                ]
            ],
            'Биллинг...' => [
                'icon'  => 'fa fa-money',
                'uri'   => 'admin',
            ],
        ];

        return $items;
    }
}