Добрый день, вы зарегистрировались в системе расчета статистики сайтов scan.getloc.ru.<br>
Ваше имя: {{$user->name}}<br>
Контактный email: {{$user->email}}<br>
<br>
Для подтверждение регистрации и защиты от злоумышленников. Необходимо активировать ваш профиль. Для этого перейдите по ссылке: <a href="http://scan.{{env('APP_DOMAIN')}}/activated?code={{$user->activation_code}}">http://scan.{{env('APP_DOMAIN')}}/activated?code={{$user->activation_code}}</a><br>
<br>
Напоминаем, что в демо-режиме доступны 3 расчета.<br>
Для дальнейшей работы необходимо заполнить форму регистрации контрагента.<br>
Стоимость каждого расчета статистики составляет 299 рублей, оплачивается единым счетом в конце месяца.<br>
<br>
Приятных вам расчетов!