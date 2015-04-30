                                
<?php 
header('Content-type: text/html; charset=utf-8');
error_reporting(E_ERROR|E_WARNING|E_PARSE|E_NOTICE);
ini_set('display_errors', 1);

# Делаем массив из рандомных значений юникс даты
$date = array(rand(1,time()),rand(1,time()),rand(1,time()),rand(1,time()),rand(1,time()));

#Выводим на экраз все значения в столбик для графического анализа

echo 'Год. День. Мес. Час. Мин. Сек.<br>';

foreach($date as $value){ 
echo "<br>".date('Y.m.d H.m.s', $value);
}

#Нужно сделать массив из значений date('Y.m.d H.m.s', $value);


foreach($date as $value){ 
$str[] = date('Y.m.d H.m.s', $value);
}

# Теперь нужно найти наименьший день и наибольший месяц:

foreach($str as $value){ 
$minday[] = substr($value,8,2);
}
echo '<br><br>Наименьший день месяца:'  .min($minday);

foreach($str as $value){ 
$maxmounth[] = substr($value,5,2);
}
echo '<br><br>Наибольший месяц:'  .max($maxmounth)."<br><br>";

#СОртируем массив по возростанию даты
//sort ($str);
//foreach($str as $value){ 
//print_r($value);
//echo '<br>';
//}


echo 'Сортируем даты по возростанию:<br>';

sort ($date);
foreach($date as $value){
echo  date('d.m.Y H.m.s', $value);
echo '<br>';
        }

        echo '<br>Последний элемент массива:<br>';        
#Извлекаем последний элемент массива в переменную $selected и выводим в форомате д.м.Г Ч.м.с

$selected=array_pop($date);

date_default_timezone_get();

echo date('d.m.Y H.m.s', $value);

#Меняем тайм зону и повторяем вывод:

date_default_timezone_set(America/New_York);

echo date('d.m.Y H.m.s', $value);

?>