<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=992">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="address=no">
    <title>@yield('title')</title>
    <link href='https://fonts.googleapis.com/css?family=Fira+Sans:400,300,500,700&subset=cyrillic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/assets/css/swiper.min.css" />
    <link rel="stylesheet" href="/assets/css/select.css" />
    <link rel="stylesheet" href="/assets/css/main.css" />
</head>
<body>
<!-- site -->
<div class="site" id="up">

    <!-- /site__header -->
    <header class="site__header">

        <!-- site__header-layout -->
        <div class="site__header-layout">

            <!-- logo -->
            <a data-href="#up" class="logo anchor">
                <img src="img/logo.png" alt="GETLOC">
            </a>
            <!-- /logo -->

            <!-- header__menu -->
            <nav class="header__menu">
                <a href="#" class="active">Возможности</a>
                <a href="#">Цены</a>
                <a href="#">О проекте</a>
            </nav>
            <!-- /header__menu -->

            <!-- btn -->
            <a class="btn btn_header popup__open" data-popup="order">Запросить демо</a>
            <!-- /btn -->

            <!-- language -->
            <div class="language">

                <!-- language__btn -->
                <button class="language__btn">RU</button>
                <!-- /language__btn -->

                <!-- language__list -->
                <ul class="language__list">
                    <li><a href="#">Русский</a></li>
                    <li><a class="active" href="#">English</a></li>
                    <li><a href="#">Deutsch</a></li>
                    <li><a href="#">Español</a></li>
                </ul>
                <!-- /language__list -->

            </div>
            <!-- /language -->

        </div>
        <!-- /site__header-layout -->

    </header>
    <!-- /site__header -->

    <!-- site__content -->
    <div class="site__content site_inner">

        <!-- site__wrap -->
        <div class="site__wrap">

            <!-- site__title -->
            <h1 class="site__title">Аналитика</h1>
            <!-- /site__title -->

            <!-- site__introduction -->
            <div class="site__introduction">
                <p>Здесь вы можете посмотреть статистику по всем проектам, которые учавствуют в тестировании сервиса.</p>
            </div>
            <!-- /site__introduction -->

            <!-- statistic -->
            <ul class="statistic">
                <li>

                    <!-- statistic__title -->
                    <span class="statistic__title">Добавлено</span>
                    <!-- /statistic__title -->

                    <!-- statistic__num -->
                    <span class="statistic__num">15</span>
                    <!-- /statistic__num -->

                    <span>сайтов</span>
                </li>
                <li>

                    <!-- statistic__title -->
                    <span class="statistic__title">Проверено</span>
                    <!-- /statistic__title -->

                    <!-- statistic__num -->
                    <span class="statistic__num">11189</span>
                    <!-- /statistic__num -->

                    <span>страниц</span>
                </li>
                <li>

                    <!-- statistic__title -->
                    <span class="statistic__title">Найдено</span>
                    <!-- /statistic__title -->

                    <!-- statistic__num -->
                    <span class="statistic__num">64243</span>
                    <!-- /statistic__num -->

                    <span>блоков</span>
                </li>
            </ul>
            <!-- /statistic -->

            <!-- site__panel -->
            <div class="site__panel">

                <!-- btn -->
                <a class="btn btn_add popup__open" data-popup="order">
                    <span>Добавить свой сайт</span>
                </a>
                <!-- /btn -->

                <!-- search -->
                <div class="search">
                    <form method="get" action="#">
                        <input type="search" name="search" placeholder="Найти сайт"/>
                        <button name="find"></button>
                    </form>
                </div>
                <!-- /search -->

            </div>
            <!-- /site__panel -->

            <!-- projects -->
            <table class="projects projects_list">
                <thead>
                <tr>
                    <td></td>
                    <td>Последние проекты</td>
                    <td class="projects__status">
                        <span>Статус</span>
                    </td>
                    <td>Страниц</td>
                    <td>Блоков</td>
                    <td>Слов</td>
                    <td>Символов</td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td><a href="#">http://www.gazprom.ru/</a></td>
                    <td class="projects__status">
                        <span class="projects__picking">Сбор текста</span>
                    </td>
                    <td>11129</td>
                    <td>63385</td>
                    <td>883808</td>
                    <td>8574580</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td><a href="#">http://www.gazprom.ru/</a></td>
                    <td class="projects__status">
                        <span class="projects__done">Обработан</span>
                    </td>
                    <td>11129</td>
                    <td>63385</td>
                    <td>883808</td>
                    <td>8574580</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td><a href="#">http://www.gazprom.ru/</a></td>
                    <td class="projects__status">
                        <span class="projects__picking">Сбор текста</span>
                    </td>
                    <td>11129</td>
                    <td>63385</td>
                    <td>883808</td>
                    <td>8574580</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td><a href="#">http://www.gazprom.ru/</a></td>
                    <td class="projects__status">
                        <span class="projects__picking">Сбор текста</span>
                    </td>
                    <td>11129</td>
                    <td>63385</td>
                    <td>883808</td>
                    <td>8574580</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td><a href="#">http://www.gazprom.ru/</a></td>
                    <td class="projects__status">
                        <span class="projects__done">Обработан</span>
                    </td>
                    <td>11129</td>
                    <td>63385</td>
                    <td>883808</td>
                    <td>8574580</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td><a href="#">http://www.gazprom.ru/</a></td>
                    <td class="projects__status">
                        <span class="projects__picking">Сбор текста</span>
                    </td>
                    <td>11129</td>
                    <td>63385</td>
                    <td>883808</td>
                    <td>8574580</td>
                </tr>
                <tr>
                    <td>7</td>
                    <td><a href="#">http://www.gazprom.ru/</a></td>
                    <td class="projects__status">
                        <span class="projects__picking">Сбор текста</span>
                    </td>
                    <td>11129</td>
                    <td>63385</td>
                    <td>883808</td>
                    <td>8574580</td>
                </tr>
                <tr>
                    <td>8</td>
                    <td><a href="#">http://www.gazprom.ru/</a></td>
                    <td class="projects__status">
                        <span class="projects__done">Обработан</span>
                    </td>
                    <td>11129</td>
                    <td>63385</td>
                    <td>883808</td>
                    <td>8574580</td>
                </tr>
                <tr>
                    <td>9</td>
                    <td><a href="#">http://www.gazprom.ru/</a></td>
                    <td class="projects__status">
                        <span class="projects__picking">Сбор текста</span>
                    </td>
                    <td>11129</td>
                    <td>63385</td>
                    <td>883808</td>
                    <td>8574580</td>
                </tr>
                <tr>
                    <td>10</td>
                    <td><a href="#">http://www.gazprom.ru/</a></td>
                    <td class="projects__status">
                        <span class="projects__picking">Сбор текста</span>
                    </td>
                    <td>11129</td>
                    <td>63385</td>
                    <td>883808</td>
                    <td>8574580</td>
                </tr>
                <tr>
                    <td>11</td>
                    <td><a href="#">http://www.gazprom.ru/</a></td>
                    <td class="projects__status">
                        <span class="projects__done">Обработан</span>
                    </td>
                    <td>11129</td>
                    <td>63385</td>
                    <td>883808</td>
                    <td>8574580</td>
                </tr>
                <tr>
                    <td>12</td>
                    <td><a href="#">http://www.gazprom.ru/</a></td>
                    <td class="projects__status">
                        <span class="projects__picking">Сбор текста</span>
                    </td>
                    <td>11129</td>
                    <td>63385</td>
                    <td>883808</td>
                    <td>8574580</td>
                </tr>
                <tr>
                    <td>13</td>
                    <td><a href="#">http://www.gazprom.ru/</a></td>
                    <td class="projects__status">
                        <span class="projects__picking">Сбор текста</span>
                    </td>
                    <td>11129</td>
                    <td>63385</td>
                    <td>883808</td>
                    <td>8574580</td>
                </tr>
                <tr>
                    <td>14</td>
                    <td><a href="#">http://www.gazprom.ru/</a></td>
                    <td class="projects__status">
                        <span class="projects__done">Обработан</span>
                    </td>
                    <td>11129</td>
                    <td>63385</td>
                    <td>883808</td>
                    <td>8574580</td>
                </tr>
                <tr>
                    <td>15</td>
                    <td><a href="#">http://www.gazprom.ru/</a></td>
                    <td class="projects__status">
                        <span class="projects__picking">Сбор текста</span>
                    </td>
                    <td>11129</td>
                    <td>63385</td>
                    <td>883808</td>
                    <td>8574580</td>
                </tr>
                <tr>
                    <td>16</td>
                    <td><a href="#">http://www.gazprom.ru/</a></td>
                    <td class="projects__status">
                        <span class="projects__picking">Сбор текста</span>
                    </td>
                    <td>11129</td>
                    <td>63385</td>
                    <td>883808</td>
                    <td>8574580</td>
                </tr>
                <tr>
                    <td>17</td>
                    <td><a href="#">http://www.gazprom.ru/</a></td>
                    <td class="projects__status">
                        <span class="projects__done">Обработан</span>
                    </td>
                    <td>11129</td>
                    <td>63385</td>
                    <td>883808</td>
                    <td>8574580</td>
                </tr>
                <tr>
                    <td>18</td>
                    <td><a href="#">http://www.gazprom.ru/</a></td>
                    <td class="projects__status">
                        <span class="projects__picking">Сбор текста</span>
                    </td>
                    <td>11129</td>
                    <td>63385</td>
                    <td>883808</td>
                    <td>8574580</td>
                </tr>
                <tr>
                    <td>19</td>
                    <td><a href="#">http://www.gazprom.ru/</a></td>
                    <td class="projects__status">
                        <span class="projects__done">Обработан</span>
                    </td>
                    <td>11129</td>
                    <td>63385</td>
                    <td>883808</td>
                    <td>8574580</td>
                </tr>
                <tr>
                    <td>20</td>
                    <td><a href="#">http://www.gazprom.ru/</a></td>
                    <td class="projects__status">
                        <span class="projects__picking">Сбор текста</span>
                    </td>
                    <td>11129</td>
                    <td>63385</td>
                    <td>883808</td>
                    <td>8574580</td>
                </tr>
                </tbody>
            </table>
            <!-- /projects -->

            <!-- paginator -->
            <div class="paginator">

                <!-- paginator__prev -->
                <a href="#" class="paginator__prev">prev</a>
                <!-- /paginator__prev -->

                <a href="#">1</a>
                <a href="#">2</a>
                <span>3</span>
                <a href="#">4</a>
                <a href="#">5</a>
                <a href="#">6</a>
                <a href="#">7</a>

                <!-- paginator__next -->
                <a href="#" class="paginator__next">next</a>
                <!-- /paginator__next -->

            </div>
            <!-- /paginator -->

        </div>
        <!-- /site__wrap -->

    </div>
    <!-- /site__content -->

    <!-- /site__footer -->
    <footer class="site__footer">
        <!-- /site__footer-layout -->
        <div class="site__footer-layout">

            <!-- footer__logo -->
            <div class="footer__logo">
                <img src="img/logo.png" alt="GETLOC">
            </div>
            <!-- /footer__logo -->

            <!-- footer-menu -->
            <div class="footer-menu">
                <dl>
                    <dt>Как это работает?</dt>
                    <dd>
                        <a href="#"><span>Наша платформа</span></a>
                        <a href="#"><span>Управление переводом</span></a>
                        <a href="#"><span>Заказ перевода</span></a>
                        <a href="#"><span>Интеграция</span></a>
                        <a href="#"><span>Планы развити</span></a>
                    </dd>
                </dl>

                <dl>
                    <dt>О нас</dt>
                    <dd>
                        <a href="#"><span>Команда проекта</span></a>
                        <a href="#"><span>Наши клиенты</span></a>
                        <a href="#"><span>Новости</span></a>
                    </dd>
                </dl>

            </div>
            <!-- /footer-menu -->

            <!-- social -->
            <div class="social">
                <a href="#" class="social-vk"></a>
                <a href="#" class="social-fb"></a>
                <a href="#" class="social-ok"></a>
            </div>
            <!-- /social -->

        </div>
        <!-- /site__footer-layout -->

    </footer>
    <!-- /site__footer -->

</div>
<!-- /site -->

<!-- popup -->
<div class="popup">
    <!-- popup__wrap -->
    <div class="popup__wrap">
        <!-- popup__content -->
        <div class="popup__content popup__order">
            <!-- order-popup -->
            <div class="order-popup">
                <!-- order-popup__content -->
                <div class="order-popup__content">

                    <!-- discount__layout -->
                    <div class="discount__layout">

                        <!-- site__title -->
                        <h2 class="site__title">Добавьте сайт</h2>
                        <!-- /site__title -->

                        <!-- popup__introduction -->
                        <div class="popup__introduction">
                            <p>Заполните форму и когда проект запуститься, у вас будет возможность пользоваться услугами сервиса со скидкой.</p>
                        </div>
                        <!-- /popup__introduction -->

                        <!-- /discount__form -->
                        <div class="discount__form">
                            <form method="get" action="#" novalidate>

                                <fieldset>
                                    <label for="discount__email">Ваша эл. почта *</label>
                                    <input type="email" id="discount__email"  placeholder="yourmail@gmai" required/>
                                </fieldset>

                                <fieldset>
                                    <label for="discount__name">Имя, фамилия</label>
                                    <input type="text" id="discount__name"/>
                                </fieldset>

                                <fieldset>
                                    <label for="discount__address">Адрес вашего сайта *</label>
                                    <input type="text" id="discount__address" placeholder="http://yoursite.ru" required/>
                                </fieldset>

                                <fieldset>
                                    <label for="discount__phone">Номер телефона</label>
                                    <input type="tel" id="discount__phone"/>
                                </fieldset>

                                <fieldset class="discount__language">
                                    <label>Язык перевода *</label>

                                    <!-- options__selects-wrap -->
                                    <div class="discount__selects-language" data-language='{
                                        "languages": [
                                            {
                                                "id": 1,
                                                "name": "Английский",
                                                "src": "img/icons-en.png"
                                            },
                                            {
                                                "id": 2,
                                                "name": "Русский",
                                                "src": "img/icons-en.png"
                                            },
                                            {
                                                "id": 3,
                                                "name": "Украинский",
                                                "src": "img/icons-ua.png"
                                            }
                                        ]
                                        }'>

                                        <!-- discount__language-wrapper -->
                                        <div class="discount__language-wrapper">

                                            <select name="lang_1" id="lang_1" required>
                                                <option value="0">Выберите язык</option>
                                            </select>

                                            <a href="#" class="discount__languadge-add">Добавить язык перевода</a>

                                        </div>
                                        <!-- /discount__language-wrapper -->

                                    </div>
                                    <!-- /discount__selects-language -->

                                </fieldset>

                                <!-- btn -->
                                <button class="btn btn_discount">
                                    <span>Добавить свой сайт</span>
                                </button>
                                <!-- /btn -->

                            </form>
                        </div>
                        <!-- discount__form -->

                    </div>
                    <!-- /discount__layout -->

                    <!-- popup__close -->
                    <button class="popup__close"><span></span></button>
                    <!-- /popup__close -->
                </div>
                <!-- /order-popup_content -->
            </div>
            <!-- /order-popup -->
        </div>
        <!-- popup__content -->
        <!-- popup__content -->
        <div class="popup__content popup__thanks">
            <!-- thanks-popup -->
            <div class="thanks-popup">
                <!-- thanks-popup__content -->
                <div class="thanks-popup__content">
                    <h2 class="thanks-popup__topic">Thank you!</h2>
                    <p>Our manager will contact you!</p>
                </div>
                <!-- /thanks-popup__content -->
            </div>
            <!-- /thanks__content -->
        </div>
        <!-- /popup__content -->
    </div>
    <!-- /popup__wrap -->
</div>
<!-- /popup -->

<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/swiper.min.js"></script>
<script src="js/jquery.nicescroll.min.js"></script>
<script src="js/jquery.select.js"></script>
<script src="js/jquery.main.js"></script>
</body>
</html>