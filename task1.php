<?php


$a = "Длина тела — до 2 м, чаще 1—1,5 м. Максимальная масса 57,7 кг[2]. Тело голое, покрытое многочисленными кожистыми выростами и костными бугорками. По обеим сторонам головы, по краю челюсти и губ свисают бахромой клочья кожи, шевелящиеся в воде, словно водоросли, что делает его малозаметным на грунте.

Туловище приплюснутое, сжатое в спинно-брюшном направлении. Голова плоская, широкая, сплющенная сверху. Рот большой, полукруглый, с выступающей вперёд нижней челюстью и острыми крючковатыми зубами. Глаза маленькие.

Жаберные отверстия широкие, расположены под основаниями грудных плавников. Мягкая кожа без чешуи; обильная кожная бахрома по краю туловища.";

# substr - выделяет символы, а не слова, обрезать и поставить ссылку на два последних целых слова можно только в списке или массиве,
# длину которого динамически будет определить накладно да и незачем
# если обрезать текст при помощи sub_str, и какое-то слово с кириллицей не полностью влезло,
# то будет появляться спец. символ �, поэтому использую mb_substr
# минусом ограничения по количеству символов является не полное помещение слова, оно просто обрезается


# Мой вариант перебирает весь текст и переобразовывает слова в элементы массива
# после чего последние два элемента помещает в ссылку

  $link2 = 'https://ru.wikipedia.org/wiki/Европейский_удильщик';
    $a2 = mb_substr($a, 0, 180);
    
    $array = explode(' ', $a2);
    $countArr = count($array);

    function lastTwoElements($array){
      
        $arrReverse = array_reverse($array);
        $complete = [$arrReverse[1], $arrReverse[0]]; #Разворачиваем массив в другую сторону и получаем эти два слова
        return $complete;

    }

    function allElements($array){
            
           array_pop($array);
           array_pop($array);
          
         return $array;
    }

    $arrayLast = implode(' ', allElements($array));
    $arrayTwoEl = implode(' ', lastTwoElements($array));

    $lastTwoElWithLink = "<a href='$link2'>$arrayTwoEl...</a>"; #Добавляем ссылку на последние два слова

    $b = $arrayLast.' '.$lastTwoElWithLink; #Объединение всего предложения с последними двумя словами ссылкой
    echo $b;


















