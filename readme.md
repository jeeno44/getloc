GetLock

Для начала необходимо создать .env файл из .env.example, указав свои настройки.
Для очередей я выбрал драйвер database на этапе разработки, потом решим. Драйвер sync не подходит, потому что выполняется
сразу после запуска и ограничен по времени настройками веб-сервера.
После настроек в .env запусктить composer install (в первый раз, в дальнейшем update) и сгенерить ключ командой
php artisan key:generate (только в первый раз)
Затем запустить миграции php artisan migrate
Для запуска задач в работу пока юзаем команду php artisan queue:listen --timeout=3600 --sleep=0, на боевом серваке 
настроим автоматический запуск.