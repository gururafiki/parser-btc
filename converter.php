<?php
	require 'libs/phpQuery.php';
    header('content-type: text/html;charset=utf-8');
	$url='https://privatbank.ua/ru/';
    //$file = file_get_contents($url);//скачиваем страницу по url
    $file='<table id="course-table-pb" class="">
                <tbody>
                <tr>
                    <td colspan="3" style="margin:0px; padding: 5px 10px; text-align: center;">
                        <select id="grpSelect" class="deselect" style="font-size: 10px;">
                            <option value="bypb" selected="selected">В отделениях</option>
                            <option value="bycard">Курсы для карт</option>
                            <option value="byvklad">Курсы для вкладов</option>
                        </select>
                    </td>
                </tr>
                </tbody>
                <tbody id="selectByPB" class="">     <!-- У відділеннях -->
                <tr>
                    <th width="24%">Валюта:</th>
                    <th width="40%" style="text-align:right;">покупка</th>
                    <th width="36%" style="text-align:right;">продажа</th>
                </tr>
                
                <tr>
                    <td width="26%">EUR/UAH</td>
                    <td width="9%" style="text-align:right;">28.1</td>
                    <td width="25%" style="text-align:right;">28.6</td>
                </tr>
                <tr>
                    <td width="26%">USD/UAH</td>
                    <td width="9%" style="text-align:right;">26.75</td>
                    <td width="25%" style="text-align:right;">27.05</td>
                </tr>
                <tr>
                    <td width="26%">RUB/UAH</td>
                    <td width="9%" style="text-align:right;">0.45</td>
                    <td width="25%" style="text-align:right;">0.49</td>
                </tr>
                
                </tbody>    <!-- // У відділеннях -->
                <tbody id="selectByCard" class="none">     <!-- Курси для карток -->
                <tr>
                    <th width="24%">Валюта:</th>
                    <th width="40%" style="text-align:right;">покупка</th>
                    <th width="36%" style="text-align:right;">продажа</th>
                </tr>
                
                <tr>
                    <td width="26%">EUR/UAH</td>
                    <td width="9%" style="text-align:right;">28.1</td>
                    <td width="25%" style="text-align:right;">28.6533</td>
                </tr>
                <tr>
                    <td width="26%">USD/UAH</td>
                    <td width="9%" style="text-align:right;">26.75</td>
                    <td width="25%" style="text-align:right;">27.1003</td>
                </tr>
                <tr>
                    <td width="26%">RUB/UAH</td>
                    <td width="9%" style="text-align:right;">0.45</td>
                    <td width="25%" style="text-align:right;">0.49</td>
                </tr>
                <tr>
                    <td width="26%">EUR/USD</td>
                    <td width="9%" style="text-align:right;">1.0441</td>
                    <td width="25%" style="text-align:right;">1.0758</td>
                </tr>
                <tr>
                    <td width="26%">EUR/RUB</td>
                    <td width="9%" style="text-align:right;">57.3464</td>
                    <td width="25%" style="text-align:right;">63.6943</td>
                </tr>
                <tr>
                    <td width="26%">USD/RUB</td>
                    <td width="9%" style="text-align:right;">55.87</td>
                    <td width="25%" style="text-align:right;">59.5238</td>
                </tr>
                
                <tr>
                    <td colspan="3" style="font-size: 10px; text-align: center;">
                        Карточные операции в валюте, отличающейся от UAH, USD, EUR и RUB, конвертируются согласно с курсами Visa/MasterCard.
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="font-size: 11px; text-align: center;">
                        <a class="link_arh" href="https://docs.google.com/a/privatbank.ua/spreadsheets/d/1Qn0uTwfgrVeeLtOO4pM9eTJjQTgqaxiXttYFhByZ-r0/edit#gid=0" target="_blank"><b>Архив</b></a>
                    </td>
                </tr>
                </tbody>      <!-- // Курси для карток -->
                <tbody id="selectByVklad" class="none">      <!-- Курси для вкладів -->
                <tr>
                    <th width="24%">Валюта:</th>
                    <th width="40%" style="text-align:right;">покупка</th>
                    <th width="36%" style="text-align:right;">продажа</th>
                </tr>
                
                <tr>
                    <td width="26%">EUR/UAH</td>
                    <td width="9%" style="text-align:right;">28.1</td>
                    <td width="25%" style="text-align:right;">28.6533</td>
                </tr>
                <tr>
                    <td width="26%">USD/UAH</td>
                    <td width="9%" style="text-align:right;">26.75</td>
                    <td width="25%" style="text-align:right;">27.1003</td>
                </tr>
                <tr>
                    <td width="26%">RUB/UAH</td>
                    <td width="9%" style="text-align:right;">0.45</td>
                    <td width="25%" style="text-align:right;">0.49</td>
                </tr>
                
                </tbody>      <!-- // Курси для вкладів -->
            </table>';
    $i=0;
    $val[0]='currency';
    $buy[0]=0.0;
    $sell[0]=0.0;
    $html = phpQuery::newDocument($file);//создать єкземпляр обьета DOM страницы
    foreach ($html->find('tbody[id*="selectByPB"]')->find('tr') as $el)//цикл для каждого ряда в таблице
    {
    		if ($i==0){
    			$i++;
    		}
    		else{
    			$val[$i]=pq($el)->find('td:eq(0)')->text();
	        	$buy[$i]=pq($el)->find('td:eq(1)')->text();
	        	$sell[$i]=pq($el)->find('td:eq(2)')->text();
	        	echo $buy[$i].'|'.$sell[$i].'|'.$i.'='.$val[$i];
	        	echo "<br>";
	        	$i++;
        	}
    }
?>