@extends('layouts.account')
@section('title') Фразы проекта @stop
@section('content') 
<div class="phrases">
    <h1 class="site__title">Фразы проекта</h1>
        <div class="tabs">
            <div class="tabs__links">
                <a href="#">Без перевода<span>1728</span></a>
                <a href="#">Переведенные<span>176</span></a>
                <a href="#">Опубликованные<span>1625 </span></a>
                <div class="tabs__links-archive">
                    <a href="#">Архив</a>
                </div>
            </div>
        <div class="phrases__control">
            <div class="nice-check">
                <input type="checkbox" id="check">
                <label for="check"></label>
            </div>
            <div class="phrases__control-inner">
                <button class="phrases__control-check"></button>
                <button class="phrases__control-delete"></button>
                <button class="phrases__control-attached"></button>
            </div>
            <button class="phrases__control-horizontal"></button>
            <button class="phrases__control-column"></button>
            <a href="#" class="btn btn_3">Заказать перевод</a>
        </div>
        <div class="tabs__content">
            <div class="phrases__tab">
                <div class="phrases__item phrases__item_mark-blue">
                    <div class="phrases__item-col">
                        Вот и пришла идея сделать такое приложение для iPad. В AppStore оказалось
                        очень много приложений подобного типа.
                    </div>
                <form class="phrases__item-col phrases__item-col_translate">
                    <textarea readonly>So entstand die Idee, eine solche Anwendung für das iPad zu machen. Im Appstore hat sehr viele Anwendungen dieses Typs.</textarea>
                    <div class="phrases__item-col-btns">
                        <button class="save" type="submit">Сохранить</button>
                        <button class="cancel">Отмена</button>
                    </div>
                </form>
                <div class="phrases__item-controls">
                    <div class="nice-check">
                        <input type="checkbox" id="publish">
                        <label for="publish">Отменить публикацию</label>
                    </div>
                    <div class="phrases__item-controls-right">
                        <div class="phrases__item-controls-menu">
                            <div>
                                <ul>
                                    <li>
                                        <a href="#">История</a>
                                    </li>
                                    <li>
                                        <a class="active" href="#">Использовать машинный перевод</a>
                                    </li>
                                    <li>
                                        <a href="#">Отметить как ручной</a>
                                    </li>
                                    <li>
                                        <a href="#">Добавить комментарий</a>
                                    </li>
                                    <li>
                                        <a href="#">Подробнее</a>
                                    </li>
                                </ul>
                                <a href="#">Отправить в архив</a>
                            </div>
                        </div>
                        <button class="phrases__item-controls-type phrases__item-controls-type_machine">
                            Машинный
                        </button>
                        <time datetime="2016-01-12">
                            <span>11:27</span>
                            12 января 2016
                        </time>
                    </div>
                </div>
            </div>
            <div class="phrases__item phrases__item_mark-blue">
                <div class="phrases__item-col">
                    © 2016 Наша компания "4 друга": Ноггано, Жора...
                </div>
                <form class="phrases__item-col phrases__item-col_translate">
                    <textarea readonly>2016 © our company "4 friend": Queue, Zhora.</textarea>
                        <div class="phrases__item-col-btns">
                            <button class="save" type="submit">Сохранить</button>
                            <button class="cancel">Отмена</button>
                        </div>
                </form>
                <div class="phrases__item-controls">
                    <div class="nice-check">
                        <input type="checkbox" id="publish2">
                        <label for="publish2">Опубликовать</label>
                    </div>
                    <div class="phrases__item-controls-right">
                        <div class="phrases__item-controls-menu">
                            <div>
                                <ul>
                                    <li>
                                        <a href="#">История</a>
                                    </li>
                                    <li>
                                        <a href="#">Использовать машинный перевод</a>
                                    </li>
                                    <li>
                                        <a href="#">Отметить как ручной</a>
                                    </li>
                                    <li>
                                        <a href="#">Добавить комментарий</a>
                                    </li>
                                    <li>
                                        <a href="#">Подробнее</a>
                                    </li>
                                </ul>
                                <a href="#">Отправить в архив</a>
                            </div>
                        </div>
                        <button class="phrases__item-controls-type phrases__item-controls-type_handler">
                            Ручной
                        </button>
                        <time datetime="2016-01-12">
                            <span>11:27</span>
                            12 января 2016
                        </time>
                    </div>
                </div>
                                        <!--/phrases__item-controls-->

                                    </div>
                                    <!--/phrases__item-->

                                    <!--phrases__item-->
                                    <div class="phrases__item phrases__item_mark-orange">

                                        <!--phrases__item-col-->
                                        <div class="phrases__item-col">
                                            Тестовый проект
                                        </div>
                                        <!--/phrases__item-col-->

                                        <!--phrases__item-col-->
                                        <form class="phrases__item-col phrases__item-col_translate">
                                            <textarea readonly> Test project</textarea>

                                            <!--phrases__item-col-btns-->
                                            <div class="phrases__item-col-btns">
                                                <button class="save" type="submit">Сохранить</button>

                                                <button class="cancel">Отмена</button>
                                            </div>
                                            <!--/phrases__item-col-btns-->

                                        </form>
                                        <!--/phrases__item-col-->

                                        <!--phrases__item-controls-->
                                        <div class="phrases__item-controls">

                                            <!--nice-check-->
                                            <div class="nice-check">
                                                <input type="checkbox" id="publish3">
                                                <label for="publish3">Отменить публикацию</label>
                                            </div>
                                            <!--/nice-check-->

                                            <!--phrases__item-controls-right-->
                                            <div class="phrases__item-controls-right">

                                                <!--phrases__item-controls-menu-->
                                                <div class="phrases__item-controls-menu">

                                                    <div>

                                                        <ul>
                                                            <li>
                                                                <a href="#">История</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Использовать машинный перевод</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Отметить как ручной</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Добавить комментарий</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Подробнее</a>
                                                            </li>
                                                        </ul>

                                                        <a href="#">Отправить в архив</a>
                                                    </div>

                                                </div>
                                                <!--/phrases__item-controls-menu-->

                                                <!--phrases__item-controls-type-->
                                                <button class="phrases__item-controls-type phrases__item-controls-type_prof">
                                                    Профессиональный
                                                </button>
                                                <!--/phrases__item-controls-type-->

                                                <time datetime="2016-01-12">
                                                    <span>11:27</span>
                                                    12 января 2016
                                                </time>

                                            </div>
                                            <!--/phrases__item-controls-right-->

                                        </div>
                                        <!--/phrases__item-controls-->

                                    </div>
                                    <!--/phrases__item-->

                                    <!--phrases__item-->
                                    <div class="phrases__item">

                                        <!--phrases__item-col-->
                                        <div class="phrases__item-col">
                                            <label for="order">Закажите перевод и нотариальное заверение</label>
                                        </div>
                                        <!--/phrases__item-col-->

                                        <!--phrases__item-col-->
                                        <div class="phrases__item-col phrases__item-col_translate">

                                            <input type="text" id="order">

                                            <!--phrases__item-btn-translate-->
                                            <button class="phrases__item-btn-translate">Использовать машинный перевод</button>
                                            <!--/phrases__item-btn-translate-->

                                        </div>
                                        <!--/phrases__item-col-->

                                        <!--phrases__item-controls-->
                                        <div class="phrases__item-controls">

                                            <!--nice-check-->
                                            <div class="nice-check">
                                                <input type="checkbox" id="publish4">
                                                <label for="publish4">Отменить публикацию</label>
                                            </div>
                                            <!--/nice-check-->

                                            <!--phrases__item-controls-right-->
                                            <div class="phrases__item-controls-right">

                                                <!--phrases__item-controls-menu-->
                                                <div class="phrases__item-controls-menu">

                                                    <div>

                                                        <ul>
                                                            <li>
                                                                <a href="#">История</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Использовать машинный перевод</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Отметить как ручной</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Добавить комментарий</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Подробнее</a>
                                                            </li>
                                                        </ul>

                                                        <a href="#">Отправить в архив</a>
                                                    </div>

                                                </div>
                                                <!--/phrases__item-controls-menu-->

                                                <time datetime="2016-01-12">
                                                    <span>11:27</span>
                                                    12 января 2016
                                                </time>

                                            </div>
                                            <!--/phrases__item-controls-right-->

                                        </div>
                                        <!--/phrases__item-controls-->

                                    </div>
                                    <!--/phrases__item-->

                                    <!--phrases__item-->
                                    <div class="phrases__item phrases__item_mark-blue">

                                        <!--phrases__item-col-->
                                        <div class="phrases__item-col">
                                            Oт 3 часов на выполнение, находимся в центре,
                                        </div>
                                        <!--/phrases__item-col-->

                                        <!--phrases__item-col-->
                                        <form class="phrases__item-col phrases__item-col_translate">
                                            <textarea readonly>from 3 hours; center of Moscow; fast delivery!</textarea>

                                            <!--phrases__item-col-btns-->
                                            <div class="phrases__item-col-btns">
                                                <button class="save" type="submit">Сохранить</button>
                                                <button class="cancel">Отмена</button>
                                            </div>
                                            <!--/phrases__item-col-btns-->

                                        </form>
                                        <!--/phrases__item-col-->

                                        <!--phrases__item-field-->
                                        <form class="phrases__item-field">

                                            <div>
                                                <label for="field1"></label>

                                                <input id="field1" type="text" value="Это такая штука, которая крепится тремя болтами к другой.">

                                                <button>close</button>
                                            </div>

                                            <!--phrases__item-col-btns-->
                                            <div class="phrases__item-col-btns">
                                                <button class="save" type="submit">Сохранить</button>
                                                <button class="cancel">Отмена</button>
                                            </div>
                                            <!--/phrases__item-col-btns-->

                                        </form>
                                        <!--/phrases__item-field-->

                                        <!--phrases__item-controls-->
                                        <div class="phrases__item-controls">

                                            <!--nice-check-->
                                            <div class="nice-check">
                                                <input type="checkbox" id="publish5">
                                                <label for="publish5">Отменить публикацию</label>
                                            </div>
                                            <!--/nice-check-->

                                            <!--phrases__item-controls-right-->
                                            <div class="phrases__item-controls-right">

                                                <!--phrases__item-controls-menu-->
                                                <div class="phrases__item-controls-menu">

                                                    <div>

                                                        <ul>
                                                            <li>
                                                                <a href="#">История</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Использовать машинный перевод</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Отметить как ручной</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Добавить комментарий</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Подробнее</a>
                                                            </li>
                                                        </ul>

                                                        <a href="#">Отправить в архив</a>
                                                    </div>

                                                </div>
                                                <!--/phrases__item-controls-menu-->

                                                <!--phrases__item-controls-type-->
                                                <button class="phrases__item-controls-type phrases__item-controls-type_handler">
                                                    Ручной
                                                </button>
                                                <!--/phrases__item-controls-type-->

                                                <time datetime="2016-01-12">
                                                    <span>11:27</span>
                                                    12 января 2016
                                                </time>

                                            </div>
                                            <!--/phrases__item-controls-right-->

                                        </div>
                                        <!--/phrases__item-controls-->

                                    </div>
                                    <!--/phrases__item-->

                                    <!--phrases__item-->
                                    <div class="phrases__item phrases__item_mark-blue">

                                        <!--phrases__item-col-->
                                        <div class="phrases__item-col">
                                            Oт 3 часов на выполнение, находимся в центре,
                                        </div>
                                        <!--/phrases__item-col-->

                                        <!--phrases__item-col-->
                                        <form class="phrases__item-col phrases__item-col_translate">
                                            <textarea readonly>from 3 hours; center of Moscow; fast delivery!</textarea>

                                            <!--phrases__item-col-btns-->
                                            <div class="phrases__item-col-btns">
                                                <button class="save" type="submit">Сохранить</button>
                                                <button class="cancel">Отмена</button>
                                            </div>
                                            <!--/phrases__item-col-btns-->

                                        </form>
                                        <!--/phrases__item-col-->

                                        <!--phrases__item-field-->
                                        <form class="phrases__item-field">

                                            <div>
                                                <label for="field2"></label>
                                                <input id="field2" type="text" value="" placeholder="Введите комментарий">
                                                <button>close</button>
                                            </div>

                                            <!--phrases__item-col-btns-->
                                            <div class="phrases__item-col-btns">
                                                <button class="save" type="submit">Сохранить</button>
                                                <button class="cancel">Отмена</button>
                                            </div>
                                            <!--/phrases__item-col-btns-->

                                        </form>
                                        <!--/phrases__item-field-->

                                        <!--phrases__item-controls-->
                                        <div class="phrases__item-controls">

                                            <!--nice-check-->
                                            <div class="nice-check">
                                                <input type="checkbox" id="publish6">
                                                <label for="publish6">Отменить публикацию</label>
                                            </div>
                                            <!--/nice-check-->

                                            <!--phrases__item-controls-right-->
                                            <div class="phrases__item-controls-right">

                                                <!--phrases__item-controls-menu-->
                                                <div class="phrases__item-controls-menu">

                                                    <div>

                                                        <ul>
                                                            <li>
                                                                <a href="#">История</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Использовать машинный перевод</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Отметить как ручной</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Добавить комментарий</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Подробнее</a>
                                                            </li>
                                                        </ul>

                                                        <a href="#">Отправить в архив</a>
                                                    </div>

                                                </div>
                                                <!--/phrases__item-controls-menu-->

                                                <!--phrases__item-controls-type-->
                                                <button class="phrases__item-controls-type phrases__item-controls-type_handler">
                                                    Ручной
                                                </button>
                                                <!--/phrases__item-controls-type-->

                                                <time datetime="2016-01-12">
                                                    <span>11:27</span>
                                                    12 января 2016
                                                </time>

                                            </div>
                                            <!--/phrases__item-controls-right-->

                                        </div>
                                        <!--/phrases__item-controls-->

                                    </div>
                                    <!--/phrases__item-->

                                    <!--phrases__item-->
                                    <div class="phrases__item phrases__item_mark-green">

                                        <!--phrases__item-col-->
                                        <div class="phrases__item-col">
                                            Тестовый проект
                                        </div>
                                        <!--/phrases__item-col-->

                                        <!--phrases__item-col-->
                                        <div class="phrases__item-col phrases__item-col_translate">
                                            <textarea readonly>Test Projects</textarea>

                                            <!--phrases__item-col-btns-->
                                            <div class="phrases__item-col-btns">
                                                <button class="save" type="submit">Сохранить</button>

                                                <button class="cancel">Отмена</button>
                                            </div>
                                            <!--/phrases__item-col-btns-->
                                        </div>
                                        <!--/phrases__item-col-->

                                        <!--phrases__item-controls-->
                                        <div class="phrases__item-controls">

                                            <!--nice-check-->
                                            <div class="nice-check">
                                                <input type="checkbox" id="publish7">
                                                <label for="publish7">Отменить публикацию</label>
                                            </div>
                                            <!--/nice-check-->

                                            <!--phrases__item-controls-right-->
                                            <div class="phrases__item-controls-right">

                                                <!--phrases__item-controls-menu-->
                                                <div class="phrases__item-controls-menu">

                                                    <div>

                                                        <ul>
                                                            <li>
                                                                <a href="#">История</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Использовать машинный перевод</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Отметить как ручной</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Добавить комментарий</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Подробнее</a>
                                                            </li>
                                                        </ul>

                                                        <a href="#">Отправить в архив</a>
                                                    </div>

                                                </div>
                                                <!--/phrases__item-controls-menu-->

                                                <!--phrases__item-controls-type-->
                                                <button class="phrases__item-controls-type phrases__item-controls-type_handler">
                                                    Ручной
                                                </button>
                                                <!--/phrases__item-controls-type-->

                                                <time datetime="2016-01-12">
                                                    <span>11:27</span>
                                                    12 января 2016
                                                </time>

                                            </div>
                                            <!--/phrases__item-controls-right-->

                                        </div>
                                        <!--/phrases__item-controls-->

                                    </div>
                                    <!--/phrases__item-->

                                    <!--phrases__item-->
                                    <div class="phrases__item phrases__item_mark-green">

                                        <!--phrases__item-col-->
                                        <div class="phrases__item-col">
                                            Служба Яндекс.Рефераты предназначена для студентов и школьников,
                                            дизайнеров и журналистов, создателей научных заявок и отчетов — для всех,
                                            кто относится к тексту, как к количеству знаков.
                                        </div>
                                        <!--/phrases__item-col-->

                                        <!--phrases__item-col-->
                                        <form class="phrases__item-col phrases__item-col_translate">

                                            <textarea readonly>Service Yandex. Abstracts is intended for students, designers and journalists</textarea>

                                            <!--phrases__item-col-btns-->
                                            <div class="phrases__item-col-btns">
                                                <button type="submit">Сохранить</button>

                                                <button>Отмена</button>
                                            </div>
                                            <!--/phrases__item-col-btns-->

                                        </form>
                                        <!--/phrases__item-col-->

                                    </div>
                                    <!--/phrases__item-->

                                    <!--phrases__item-->
                                    <div class="phrases__item phrases__item_mark-blue">

                                        <!--phrases__item-col-->
                                        <div class="phrases__item-col phrases__item-col_block">
                                            Вот и пришла идея сделать такое приложение для iPad. В AppStore оказалось
                                            очень много приложений подобного типа.
                                        </div>
                                        <!--/phrases__item-col-->

                                        <!--phrases__item-col-->
                                        <div class="phrases__item-col phrases__item-col_block phrases__item-col_translate">

                                            <textarea readonly>So entstand die Idee, eine solche Anwendung für das iPad zu machen. Im Appstore hat sehr viele Anwendungen dieses Typs.</textarea>

                                            <!--phrases__item-col-btns-->
                                            <div class="phrases__item-col-btns">
                                                <button class="save" type="submit">Сохранить</button>

                                                <button class="cancel">Отмена</button>
                                            </div>
                                            <!--/phrases__item-col-btns-->

                                        </div>
                                        <!--/phrases__item-col-->

                                        <!--phrases__item-controls-->
                                        <div class="phrases__item-controls">

                                            <!--nice-check-->
                                            <div class="nice-check">
                                                <input type="checkbox" id="publish8">
                                                <label for="publish8">Отменить публикацию</label>
                                            </div>
                                            <!--/nice-check-->

                                            <!--phrases__item-controls-right-->
                                            <div class="phrases__item-controls-right">

                                                <!--phrases__item-controls-menu-->
                                                <div class="phrases__item-controls-menu">

                                                    <div>

                                                        <ul>
                                                            <li>
                                                                <a href="#">История</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Использовать машинный перевод</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Отметить как ручной</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Добавить комментарий</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Подробнее</a>
                                                            </li>
                                                        </ul>

                                                        <a href="#">Отправить в архив</a>
                                                    </div>

                                                </div>
                                                <!--/phrases__item-controls-menu-->

                                                <!--phrases__item-controls-type-->
                                                <button class="phrases__item-controls-type phrases__item-controls-type_handler">
                                                    Ручной
                                                </button>
                                                <!--/phrases__item-controls-type-->

                                                <time datetime="2016-01-12">
                                                    <span>11:27</span>
                                                    12 января 2016
                                                </time>

                                            </div>
                                            <!--/phrases__item-controls-right-->

                                        </div>
                                        <!--/phrases__item-controls-->

                                    </div>
                                    <!--/phrases__item-->

                                </div>
                                <!--/phrases__tab-->

                            </div>
                            <!-- tabs__content -->

                        </div>
                        <!--/tabs__wrap-->

                    </div>
@stop