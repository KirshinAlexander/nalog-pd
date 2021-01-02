# Проверка статуса физического лица, является ли оно самозанятым

## Установка

С помощью composer:

    composer require kirshin/kirshin/nalog-pd

### Использование

    use Kirshin\CheckNalog\CheckNalog;
    
    
    $request = new CheckNalogPd("ваш_инн");
    $response = $request->check();
    $response["status"] - статус на заданную дату, или если не передана дата, то статус за предыдущий день (true/false)
    $response["message"] - "сообщение с описаниением  результата запроса"
