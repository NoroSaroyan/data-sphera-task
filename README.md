
## Стэк:
- Php
- Laravel
- Docker
- amoCRM API Library
- amoCRM Provider для OAuth 2.0 Client

## Функционал  

- Сохранения токенов
- Обновление токенов 
- Интеграция с amoCrm

## Какую работу проделал
- Изучил документации amoCrm по ссылкам: https://github.com/amocrm/amocrm-oauth-client  https://github.com/amocrm/amocrm-api-php#%D0%BA%D0%BE%D0%BD%D1%81%D1%82%D0%B0%D0%BD%D1%82%D1%8B  https://www.amocrm.ru/developers/content/crm_platform/api-reference https://www.amocrm.ru/developers/content/digital_pipeline/site_visit
- Изучил документацию PHP по ссылке: https://www.php.net/docs.php
- Изпользовал полученные навыки и информацию из прочитанных документации в техническом задании.  
- Для исправной работы докера нашел команду 
 curl -s "https://laravel.build/data-sphera?with=pgsql&devcontainer" | bash
- Прочитал документацию "Docker" по ссылке: https://docs.docker.com/ 
- Прочитал документацию "PhpStorm": https://www.jetbrains.com/help/phpstorm/quick-start-guide-phpstorm.html
- Прочитал документацию "Visual Studio Code": https://code.visualstudio.com/docs

## Использование
#### Как поднять приложение:
- Октрываем терминал
- Пишем команду curl -s "https://laravel.build/data-sphera?with=pgsql&devcontainer" | bash
- Пишем команду cd data-sphera && ./vendor/bin/sail up 
 (учитываете, что у вас приложение может быть в другом месте)
- Открываем Visual Studio code
- Справа снизу появится кнопка "Reopen in container", нажимаем на нее. 
- Все! Приложение уже работает в docker контейнере. 
- Открываем браузер
- Пишем localhost:80 или 0.0.0.0:80 и готово! 
