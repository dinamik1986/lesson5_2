<?php

header('Content-type: text/html; charset=utf-8');
error_reporting(E_ERROR|E_WARNING|E_PARSE|E_NOTICE);
ini_set('display_errors', 1);



/*
 * Следующие задания требуется воспринимать как ТЗ (Техническое задание)
 * p.s. Разработчик, помни! 
 * Лучше уточнить ТЗ перед выполнением у заказчика, если ты что-то не понял, чем сделать, переделать, потерять время, деньги, нервы, репутацию.
 * Не забывай о навыках коммуникации :)
 * 
 * Задание 1
 * - Вы проектируете интернет магазин. Посетитель на вашем сайте создал следующий заказ (цена, количество в заказе и остаток на складе генерируются автоматически):
 */
$ini_string='
[игрушка мягкая мишка белый]
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';
осталось на складе = '.  mt_rand(0, 10).';
diskont = diskont'.  mt_rand(0, 2).';
    
[одежда детская куртка синяя синтепон]
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';
осталось на складе = '.  mt_rand(0, 10).';
diskont = diskont'.  mt_rand(0, 2).';
    
[игрушка детская велосипед]
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';
осталось на складе = '.  mt_rand(0, 10).';
diskont = diskont'.  mt_rand(0, 2).';

';
$bd=  parse_ini_string($ini_string, true);
//print_r($bd);
//зададим глобальныеы переменные для вывода в ИТОГО.
$itogo = 0;
$kol_naimenovanii = 0;
$obshee_kol_tovara = 0;
// Зададим глобальные переменные для вывода информации о недостаточном количестве товаров на складе.
$uvedomlenie = 0;
$naimen_nedost ='';

//Зададим переменную вывода раздела Скидки:
$skidka30 = 0;

echo ('<h3>Корзина покупок:</h3><br>');

function parsebusket($basket)
{

echo '<style type="text/css">
    table {
        border-collapse: collapse;
    }
    table th,
    table td {
        padding: 0 3px;
    }
    table.brd th,
    table.brd td {
        border: 1px solid #000;
    }
</style>

   <table class="brd">
    <tr>
        <th width="400">Наименование товара:</th>
        <th width="150">Цена за ед:</th>
        <th width="150">Скидка:</th>
        <th width="150">Цена со скидкой:</th>
        <th width="150">Количество заказано:</th>
        <th width="150">Наличие на складе:</th>
        <th width="150">Стоимость (по наличию):</th>
    </tr>
 </table>';
    
    foreach ($basket as $name => $value)
    {

        
       $discount = discount($value['цена'],$value['количество заказано'],$value['diskont'],$value['осталось на складе'],$name);

            
   echo '<table>
    <tr>
        <th width="400">'.$name.'</th>
        <th width="150">'.$value['цена'].'</th>
        <th width="150">'.$discount['skidka'].'</th>
        <th width="150">'.$discount['price_skidka'].'</th>
        <th width="150">'.$value['количество заказано'].'</th>
        <th width="150">'.$value['осталось на складе'].'</th>
        <th width="150">'.$discount['price'].'</th>
    </tr>
 </table>';
        
        echo '<br>';
        
    itogo($discount['price'],$value['количество заказано'],$value['осталось на складе']);
    }   
}

function discount($price, $amount, $diskont, $ostatok, $name) {
global $uvedomlenie;
global $naimen_nedost;
global $skidka30;
        

    $skidka = substr($diskont, 7, 2);
//Зададим проверку условия покупки 3 велосипедов, учитывая, что на складе тоже есть 3 велосипеда!
    if ($name == 'игрушка детская велосипед' && $amount >= '3' && $ostatok >= '3') {
        
        $skidka30 =1;

        $price_per_item_with_discount = 0.7 * $price;
        $skidka = 3;
    } else {
        $price_per_item_with_discount = $price - $price * ($skidka / 10);
    }
    //Зададим условие проверки соответствия количества заказанного товара и количества на складе.
    if ($amount <= $ostatok) {

        $total_price_all_items_with_discount = $amount * $price_per_item_with_discount;
    } else {
        $uvedomlenie = 1;
        $naimen_nedost = $naimen_nedost.$name.'<br>';
        $total_price_all_items_with_discount = $ostatok * $price_per_item_with_discount;
    }

    return array('skidka' => $skidka . "0%",
        'price_skidka' => $price_per_item_with_discount,
        'price' => $total_price_all_items_with_discount
    );
}
//функция, высчитывающая общую сумму, количество заказанного товара и количество позиций.
function itogo($price, $kol_vo, $sklad) {
    global $itogo;
    global $kol_naimenovanii;
    global $obshee_kol_tovara;
    
    $itogo = $itogo + $price;
    
    $kol_naimenovanii = $kol_naimenovanii + 1;
    
    if ($kol_vo <=$sklad)
    {
    $obshee_kol_tovara = $obshee_kol_tovara + $kol_vo;
    }
else{
    $obshee_kol_tovara = $obshee_kol_tovara + $sklad;
}
}
    
    
parsebusket($bd);

if ($uvedomlenie == 1) {
    echo '<b>Уведомление:</b><br>';
        echo '<span style="color: #FF0303;"><b>Внимание! На складе имеется недостаточное количество товаров: '
    . '<br> ' .$naimen_nedost.' Стоимость будет посчитана в соответствии с имеющимся количеством товара на складе!</span></b><br><br>';
       
}

if ($skidka30 == 1) {
    
    echo '<b>Скидки:</b><br>';
        echo '<span style="color: #FF0303;"><b>Вы заказали "игрушка детская велосипед" в количестве 3 '
    . 'или более штук, они есть на складе и Вам скидка 30%!!!<br> </span></b><br>';
    
}


echo '<b>ИТОГО:</b><br>';
echo 'Общая стоимость товара:'.$itogo.'<br> '
        . 'Общее количество заказанного товара:'.$obshee_kol_tovara.'<br>'
        . 'Всего наименований заказано:'.$kol_naimenovanii.'<br>';


/*
 * 
 * - Вам нужно вывести корзину для покупателя, где указать: 
 * 1) Перечень заказанных товаров, их цену, кол-во и остаток на складе
 * 2) В секции ИТОГО должно быть указано: сколько всего наименовний было заказано, каково общее количество товара, какова общая сумма заказа
 * - Вам нужно сделать секцию "Уведомления", где необходимо извещать покупателя о том, что нужного количества товара не оказалось на складе
 * - Вам нужно сделать секцию "Скидки", где известить покупателя о том, что если он заказал "игрушка детская велосипед" в количестве >=3 штук, то на эту позицию ему 
 * автоматически дается скидка 30% (соответственно цены в корзине пересчитываются тоже автоматически)
 * 3) у каждого товара есть автоматически генерируемый скидочный купон diskont, используйте переменную функцию, чтобы делать скидку на итоговую цену в корзине
 * diskont0 = скидок нет, diskont1 = 10%, diskont2 = 20%
 * 
 * В коде должно быть использовано:
 * - не менее одной функции
 * - не менее одного параметра для функции
 * операторы if, else, switch
 * статические и глобальные переменные в теле функции
 * 

 */

