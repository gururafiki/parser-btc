<?php
	require "db.php";
    require "libs/phpQuery.php";
    header('content-type: text/html;charset=utf-8');

function online_local_btc($usd_sell,$eur_sell,$rub_sell)
{
    $url = 'https://localbitcoins.com/buy-bitcoins-online/ua/ukraine/';
    $file = file_get_contents($url);//скачиваем страницу по url
    $html_code = htmlspecialchars($file);//для вывода html

    $html = phpQuery::newDocument($file);//создать єкземпляр обьета DOM страницы
    foreach ($html->find('table')->find('tr[class*="clickable"') as $el)//цикл для каждого ряда в таблице
    {
        $seller = pq($el)->find('td[class*="column-user"]')->text();//достать текст внутри колонки
        $seller_url = pq($el)->find('td[class*="column-user"]')->find('a')->attr('href');//достать значение атрибута гиперссылки
        $price = pq($el)->find('td[class*="column-price"]')->text();
        $limit = pq($el)->find('td[class*="column-limit"]')->text();
        $button = pq($el)->find('td[class*="column-button"]')->find('a')->attr('href');
        //начало обработчика валюты
        $val = 'currency';//переменная ,хранящая валюту
        $find_val = 'UAH';
        $converted_price=0;
        $pos = strpos($price, $find_val);//поиск слова UAH в колонке price
        if ($pos === false) {//если UAH нету в строке
            $find_val = 'USD';
            $pos = strpos($price, $find_val);
            if ($pos === false) {//если USD нету в строке
                $find_val = 'EUR';
                $pos = strpos($price, $find_val);
                if ($pos === false) {//Если EUR нету в строке
                    $find_val = 'RUB';
                    $pos = strpos($price, $find_val);
                    if ($pos === false) $val = 'Incorret currency';//Если не нашли нужные валюты
                    else{ 
                        $val = 'RUB';
                        $price = trim($price);//избавится от пробелов и всех лишних символов
                        $price = trim($price, 'RUB');//избавится от названия валюты
                        $converted_price=$price*$rub_sell;

                    }
                } 
                else{ 
                    $val = 'EUR';
                    $price = trim($price);//избавится от пробелов и всех лишних символов
                    $price = trim($price, 'EUR');//избавится от названия валюты
                    $converted_price=$price*$eur_sell;
                }
            } 
            else{
                $val = 'USD';
                $price = trim($price);//избавится от пробелов и всех лишних символов
                $price = trim($price, 'USD');//избавится от названия валюты
                $converted_price=$price*$usd_sell;
            }
        } 
        else {
            $val = 'UAH';
            $price = trim($price);//избавится от пробелов и всех лишних символов
            $price = trim($price, 'UAH');//избавится от названия валюты
        }
        $limit = trim($limit);
        $limit = trim($limit, 'UAHSDERB');
        $row = R::dispense('sellers');//создать обьект для базы данных online
        $row->seller = iconv("windows-1251", "UTF-8", trim($seller));//сохранение в базу данных с учетом кодировки,что бы избежать АбрАкАдАбрЫ
        $row->seller_url = iconv("windows-1251", "UTF-8", 'https://localbitcoins.com' . $seller_url);//третий параметр добавляет к вытянутой гиперссылке название сайта,что бы можно было по ней переходить
        $row->price = iconv("windows-1251", "UTF-8", $price);
        $row->currency = $val;
        if($converted_price!=0){
            $row->price_in_uah = $converted_price;
        }
        $row->limit = iconv("windows-1251", "UTF-8", $limit);
        $row->url = iconv("windows-1251", "UTF-8", 'https://localbitcoins.com' . $button);
        R::store($row);//сохранить в базу данных
    }
    phpQuery::unloadDocuments();//очистить оперативку от последствий парсинга
}
    //для таблицы "купить за наличку"
function cash_local_btc($usd_sell,$eur_sell,$rub_sell)
{
    $url = 'https://localbitcoins.com/buy-bitcoins-with-cash/1167227144/kiev-ukraine-02000/';
    $file = file_get_contents($url);//скачиваем страницу по url
    $i=1;
    $html = phpQuery::newDocument($file);//создать єкземпляр обьета DOM страницы
    foreach ($html->find('table')->find('tr') as $el)//цикл для каждого ряда в таблице
    {
        if($i==1){//что бы пропустить первую строку с названиями колонок
            $i++;
        }
        else {
            $seller = pq($el)->find('td[class*="column-user"]')->text();//достать текст внутри колонки
            $seller_url = pq($el)->find('td[class*="column-user"]')->find('a')->attr('href');//достать значение атрибута гиперссылки
            $location = pq($el)->find('td[class*="column-location"]')->text();
            $price = pq($el)->find('td[class*="column-price"]')->text();
            $limit = pq($el)->find('td[class*="column-limit"]')->text();
            $button = pq($el)->find('td[class*="column-button"]')->find('a')->attr('href');
            //начало обработчика валюты
            $val = 'currency';//переменная ,хранящая валюту
            $find_val = 'UAH';
            $converted_price=0;
            $pos = strpos($price, $find_val);//поиск слова UAH в колонке price
            if ($pos === false) {//если UAH нету в строке
                $find_val = 'USD';
                $pos = strpos($price, $find_val);
                if ($pos === false) {//если USD нету в строке
                    $find_val = 'EUR';
                    $pos = strpos($price, $find_val);
                    if ($pos === false) {//Если EUR нету в строке
                        $find_val = 'RUB';
                        $pos = strpos($price, $find_val);
                        if ($pos === false) $val = 'Incorret currency';//Если не нашли нужные валюты
                        else{ 
                            $val = 'RUB';
                            $price = trim($price);//избавится от пробелов и всех лишних символов
                            $price = trim($price, 'RUB');//избавится от названия валюты
                            $converted_price=$price*$rub_sell;

                        }
                    } 
                    else{ 
                        $val = 'EUR';
                        $price = trim($price);//избавится от пробелов и всех лишних символов
                        $price = trim($price, 'EUR');//избавится от названия валюты
                        $converted_price=$price*$eur_sell;
                    }
                } 
                else{
                    $val = 'USD';
                    $price = trim($price);//избавится от пробелов и всех лишних символов
                    $price = trim($price, 'USD');//избавится от названия валюты
                    $converted_price=$price*$usd_sell;
                }
            } 
            else {
                $val = 'UAH';
                $price = trim($price);//избавится от пробелов и всех лишних символов
                $price = trim($price, 'UAH');//избавится от названия валюты
            }
            $limit = trim($limit);
            $limit = trim($limit, 'UAHSDERB');
            $row = R::dispense('sellers');//создать обьект для базы данных online
            $row->seller = iconv("windows-1251", "UTF-8", trim($seller));//сохранение в базу данных с учетом кодировки,что бы избежать АбрАкАдАбрЫ
            $row->seller_url = iconv("windows-1251", "UTF-8", 'https://localbitcoins.com' . $seller_url);//третий параметр добавляет к вытянутой гиперссылке название сайта,что бы можно было по ней переходить
            $row->price = iconv("windows-1251", "UTF-8", $price);
            $row->location = iconv("windows-1251", "UTF-8", trim($location));
            $row->currency = $val;
            if($converted_price!=0){
                $row->price_in_uah = $converted_price;
            }
            $row->limit = iconv("windows-1251", "UTF-8", $limit);
            $row->url = iconv("windows-1251", "UTF-8", 'https://localbitcoins.com' . $button);
            R::store($row);//сохранить в базу данных
        }
    }
    phpQuery::unloadDocuments();//очистить оперативку от последствий парсинга
}
function sell_online_local_btc($usd_buy,$eur_buy,$rub_buy)
{
    $url = 'https://localbitcoins.com/sell-bitcoins-online/UA/ukraine/';
    $file = file_get_contents($url);//скачиваем страницу по url
    $html_code = htmlspecialchars($file);//для вывода html

    $html = phpQuery::newDocument($file);//создать єкземпляр обьета DOM страницы
    foreach ($html->find('table')->find('tr[class*="clickable"') as $el)//цикл для каждого ряда в таблице
    {
        $buyer = pq($el)->find('td[class*="column-user"]')->text();//достать текст внутри колонки
        $buyer_url = pq($el)->find('td[class*="column-user"]')->find('a')->attr('href');//достать значение атрибута гиперссылки
        $price = pq($el)->find('td[class*="column-price"]')->text();
        $limit = pq($el)->find('td[class*="column-limit"]')->text();
        $button = pq($el)->find('td[class*="column-button"]')->find('a')->attr('href');
        //начало обработчика валюты
        $val = 'currency';//переменная ,хранящая валюту
        $find_val = 'UAH';
        $converted_price=0;
        $pos = strpos($price, $find_val);//поиск слова UAH в колонке price
        if ($pos === false) {//если UAH нету в строке
            $find_val = 'USD';
            $pos = strpos($price, $find_val);
            if ($pos === false) {//если USD нету в строке
                $find_val = 'EUR';
                $pos = strpos($price, $find_val);
                if ($pos === false) {//Если EUR нету в строке
                    $find_val = 'RUB';
                    $pos = strpos($price, $find_val);
                    if ($pos === false) $val = 'Incorret currency';//Если не нашли нужные валюты
                    else{ 
                        $val = 'RUB';
                        $price = trim($price);//избавится от пробелов и всех лишних символов
                        $price = trim($price, 'RUB');//избавится от названия валюты
                        $converted_price=$price*$rub_buy;

                    }
                } 
                else{ 
                    $val = 'EUR';
                    $price = trim($price);//избавится от пробелов и всех лишних символов
                    $price = trim($price, 'EUR');//избавится от названия валюты
                    $converted_price=$price*$eur_buy;
                }
            } 
            else{
                $val = 'USD';
                $price = trim($price);//избавится от пробелов и всех лишних символов
                $price = trim($price, 'USD');//избавится от названия валюты
                $converted_price=$price*$usd_buy;
            }
        } 
        else {
            $val = 'UAH';
            $price = trim($price);//избавится от пробелов и всех лишних символов
            $price = trim($price, 'UAH');//избавится от названия валюты
        }
        $limit = trim($limit);
        $limit = trim($limit, 'UAHSDERB');
        $row = R::dispense('buyers');//создать обьект для базы данных online
        $row->buyer = iconv("windows-1251", "UTF-8", trim($buyer));//сохранение в базу данных с учетом кодировки,что бы избежать АбрАкАдАбрЫ
        $row->buyer_url = iconv("windows-1251", "UTF-8", 'https://localbitcoins.com' . $buyer_url);//третий параметр добавляет к вытянутой гиперссылке название сайта,что бы можно было по ней переходить
        $row->price = iconv("windows-1251", "UTF-8", $price);
        $row->currency = $val;
        if($converted_price!=0){
            $row->price_in_uah = $converted_price;
        }
        $row->limit = iconv("windows-1251", "UTF-8", $limit);
        $row->url = iconv("windows-1251", "UTF-8", 'https://localbitcoins.com' . $button);
        R::store($row);//сохранить в базу данных
    }
    phpQuery::unloadDocuments();//очистить оперативку от последствий парсинга
}
function sell_cash_local_btc($usd_buy,$eur_buy,$rub_buy)
{
    $url = 'https://localbitcoins.com/buy-bitcoins-with-cash/1167227144/kiev-ukraine-02000/';
    $file = file_get_contents($url);//скачиваем страницу по url
    $i=1;
    $html = phpQuery::newDocument($file);//создать єкземпляр обьета DOM страницы
    foreach ($html->find('table')->find('tr') as $el)//цикл для каждого ряда в таблице
    {
        if($i==1){//что бы пропустить первую строку с названиями колонок
            $i++;
        }
        else {
            $buyer = pq($el)->find('td[class*="column-user"]')->text();//достать текст внутри колонки
            $buyer_url = pq($el)->find('td[class*="column-user"]')->find('a')->attr('href');//достать значение атрибута гиперссылки
            $location = pq($el)->find('td[class*="column-location"]')->text();
            $price = pq($el)->find('td[class*="column-price"]')->text();
            $limit = pq($el)->find('td[class*="column-limit"]')->text();
            $button = pq($el)->find('td[class*="column-button"]')->find('a')->attr('href');
            //начало обработчика валюты
            $val = 'currency';//переменная ,хранящая валюту
            $find_val = 'UAH';
            $converted_price=0;
            $pos = strpos($price, $find_val);//поиск слова UAH в колонке price
            if ($pos === false) {//если UAH нету в строке
                $find_val = 'USD';
                $pos = strpos($price, $find_val);
                if ($pos === false) {//если USD нету в строке
                    $find_val = 'EUR';
                    $pos = strpos($price, $find_val);
                    if ($pos === false) {//Если EUR нету в строке
                        $find_val = 'RUB';
                        $pos = strpos($price, $find_val);
                        if ($pos === false) $val = 'Incorret currency';//Если не нашли нужные валюты
                        else{ 
                            $val = 'RUB';
                            $price = trim($price);//избавится от пробелов и всех лишних символов
                            $price = trim($price, 'RUB');//избавится от названия валюты
                            $converted_price=$price*$rub_buy;

                        }
                    } 
                    else{ 
                        $val = 'EUR';
                        $price = trim($price);//избавится от пробелов и всех лишних символов
                        $price = trim($price, 'EUR');//избавится от названия валюты
                        $converted_price=$price*$eur_buy;
                    }
                } 
                else{
                    $val = 'USD';
                    $price = trim($price);//избавится от пробелов и всех лишних символов
                    $price = trim($price, 'USD');//избавится от названия валюты
                    $converted_price=$price*$usd_buy;
                }
            } 
            else {
                $val = 'UAH';
                $price = trim($price);//избавится от пробелов и всех лишних символов
                $price = trim($price, 'UAH');//избавится от названия валюты
            }
            $limit = trim($limit);
            $limit = trim($limit, 'UAHSDERB');
            $row = R::dispense('buyers');//создать обьект для базы данных online
            $row->buyer = iconv("windows-1251", "UTF-8", trim($buyer));//сохранение в базу данных с учетом кодировки,что бы избежать АбрАкАдАбрЫ
            $row->buyer_url = iconv("windows-1251", "UTF-8", 'https://localbitcoins.com' . $buyer_url);//третий параметр добавляет к вытянутой гиперссылке название сайта,что бы можно было по ней переходить
            $row->price = iconv("windows-1251", "UTF-8", $price);
            $row->location = iconv("windows-1251", "UTF-8", trim($location));
            $row->currency = $val;
            if($converted_price!=0){
                $row->price_in_uah = $converted_price;
            }
            $row->limit = iconv("windows-1251", "UTF-8", $limit);
            $row->url = iconv("windows-1251", "UTF-8", 'https://localbitcoins.com' . $button);
            R::store($row);//сохранить в базу данных
        }
    }
    phpQuery::unloadDocuments();//очистить оперативку от последствий парсинга
}
    $url='http://finance.i.ua/bank/10/';
    $file = file_get_contents($url);//скачиваем страницу по url
    $html_code = htmlspecialchars($file);
    $i=1;
    $j=1;
    $html = phpQuery::newDocument($file);//создать єкземпляр обьета DOM страницы
    foreach ($html->find('div[class*="data_container"]')->find('span[class*="value"]') as $el) {
        if($i%2==0){
            $course[$j]['sell']=pq($el)->find('span:eq(0)')->text();
            $j++;   
        }
        else{
            $course[$j]['buy']=pq($el)->find('span:eq(0)')->text();
        }
        $i++;
    }
    //1-USD;2-EUR;3-RUB;
    phpQuery::unloadDocuments();
R::nuke();// удалить существующую базу данных
online_local_btc($course[1]['sell'],$course[2]['sell'],$course[3]['sell']);//вызов функции парсинга первой таблицы
cash_local_btc($course[1]['sell'],$course[2]['sell'],$course[3]['sell']);//парсинг второй таблицы
sell_online_local_btc($course[1]['buy'],$course[2]['buy'],$course[3]['buy']);
sell_cash_local_btc($course[1]['buy'],$course[2]['buy'],$course[3]['buy']);
?>