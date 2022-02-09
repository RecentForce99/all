<?php
//ini_set('session.save_path');
////realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/sessions'));
//session_start();
//ini_set('session.gc_maxlifetime', 2592000);
//session_start();
//echo $maxlifetime = ini_get("session.gc_maxlifetime");
//session_save_path();


//print_r($_POST);

// ООП - определение, прочитать WIKI - сказать что непонятно в вопросе ДЗ
// для описания алгоритма используются взаимодействующие объекты (экземпляры класса)
// методы для взаимодействия публичные - доступны, методы внутренней реализации - скрытые
// логика алгоритма выглядит проще, если скрывать незначительные детали и выстраивать взаимодействие между объектами на разных уровнях

// https://ru.wikipedia.org/wiki/%D0%9E%D0%B1%D1%8A%D0%B5%D0%BA%D1%82%D0%BD%D0%BE-%D0%BE%D1%80%D0%B8%D0%B5%D0%BD%D1%82%D0%B8%D1%80%D0%BE%D0%B2%D0%B0%D0%BD%D0%BD%D0%BE%D0%B5_%D0%BF%D1%80%D0%BE%D0%B3%D1%80%D0%B0%D0%BC%D0%BC%D0%B8%D1%80%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D0%B5
// https://habr.com/ru/post/87119/
// https://habr.com/ru/post/87205/
// http://www.codenet.ru/progr/cpp/ipn.php
// https://medium.com/@volkov97/%D0%BE%D1%81%D0%BD%D0%BE%D0%B2%D0%BD%D1%8B%D0%B5-%D0%BA%D0%BE%D0%BD%D1%86%D0%B5%D0%BF%D1%86%D0%B8%D0%B8-%D0%BE%D0%BE%D0%BF-9c61d16e693b

// !абстракция
// инкапсуляция
// наследование
// полиморфизм

// OOP PHP https://refactoring.guru/ru/design-patterns/php

// Практики: (DRY) KISS SOLID
// https://habr.com/ru/company/itelma/blog/546372/

//------------------------------------------------------------------------------------------------------------------
abstract class Component
{
    protected $parent;

    public $pehota = [];
    public $luchniki = [];
    public $konnical = [];


    public function setParent(Component $parent)
    {
        $this->parent = $parent;
    }

    public function getParent(): Component
    {
        return $this->parent;
    }

    public function add(Component $component): void { }

    public function remove(Component $component): void { }


    public function isComposite(): bool
    {
        return false;
    }


    abstract public function operation();
}


class Aleksandr extends Component
{
    public function operation()
    {
        $army = [
            'name' => 'Александр Ярославич',
            'units' => [
                'pehota' => 200,
                'luchniki' => 30,
                'konnica' => 15,
            ]
        ];

        return $army;
    }
}

class Ulf extends Component
{
    public function operation()
    {
        $army = [
            'name' => 'Ульф Фасе',
            'units' => [
                'pehota' => 90,
                'luchniki' => 65,
                'konnica' => 25,
            ]
        ];

        return $army;
    }
}


class Composite extends Component
{

    protected $children;

    public function __construct()
    {
        $this->children = new \SplObjectStorage();
    }


    public function add(Component $component): void
    {
        $this->children->attach($component);
        $component->setParent($this);
    }

    public function remove(Component $component): void
    {
        $this->children->detach($component);
        $component->setParent(null);
    }

    public function isComposite(): bool
    {
        return true;
    }


    public function operation(): string
    {
        $results = [];
        foreach ($this->children as $child) {
            $results[] = $child->operation();
        }

        return "Branch(" . implode("+", $results) . ")";
    }
}

function clientCode(Component $component, $army, $health)
{

    echo "<table border='1'>
            <tr>
            <th></th>
            <th>$army['name']</th>
            <th>$army['name']</th>
        </tr>
        <tr>
            <th>Army units:</th>
            <td>unit1 (count), unit2(count), ...</td>
            <td>unit1 (count), unit2(count), ...</td>
        </tr>
        <tr>
            <th>Погибшие</th>
            <td>$health1</td>
            <td>$health2</td>
        </tr>
        <tr>
            <th>Выжившие</th>
            <td>$health1</td>
            <td>$health2</td>
        </tr>";

        $duration = 0; //Убрать
        while ($health1 >= 0 && $health2 >= 0) {
            $health1 -= $damage2;
            $health2 -= $damage1;
            $duration++;
        }

        echo " <tr>
            <th>Health after $duration hits:</th>
            <td>$health1</td>
            <td>$health2</td>
        </tr>
        <tr>
            <th>Result</th>
            <td>$health1 > $health2 ? 'WINNER' : 'LOOSER'</td>
            <td>$health2 > $health1 ? 'WINNER' : 'LOOSER'</td>
        </tr>
        </table>";


     print_r($component->operation());

    // ...
}

$simple = new Aleksandr();
echo "Client: I've got a simple component:\n";
clientCode($simple);
echo "\n\n";

$pehota = [
    'health' => 100,
    'armour' => 10,
    'damage' => 10,
];

$luchniki = [
    'health' => 100,
    'armour' => 5,
    'damage' => 20,
];

$konnica = [
    'health' => 300,
    'armour' => 30,
    'damage' => 30,
];

// Создаём две армии (кол-во юнитов)
$army1 = [
    'name' => 'Александр Ярославич',
    'units' => [
        'pehota' => 200,
        'luchniki' => 30,
        'konnica' => 15,
    ]
];
$army2 = [
    'name' => 'Ульф Фасе',
    'units' => [
        'pehota' => 90,
        'luchniki' => 65,
        'konnica' => 25,
    ]
];

// Запускаем битву.
$damage1 = 0;
$health1 = 0;
foreach ($army1['units'] as $unit => $count) {
    $damage1 += ${$unit}['damage'] * $count;
    $health1 += ${$unit}['health'] * $count + ${$unit}['armour'] * $count;
}

$damage2 = 0;
$health2 = 0;
foreach ($army2['units'] as $unit => $count) {
    $damage2 += ${$unit}['damage'] * $count;
    $health2 += ${$unit}['health'] * $count + ${$unit}['armour'] * $count;
}

$calc_army_damage_health = function ($army) use ($pehota, $luchniki, $konnica)
{
    $damage = 0;
    $health = 0;

    foreach ($army['units'] as $unit => $count) {
        $damage += ${$unit}['damage'] * $count;
        $health += ${$unit}['health'] * $count + ${$unit}['armour'] * $count;
    }

    return [$damage, $health];
};
//echo $damage1;
print_r($calc_army_damage_health($army1));
//list($damage1, $damage2) = calc_army_damage_health($army1);

?>

<?php
?>


<?php
































die();

// TODO намеренно плохой код! задача - отрефакторить, используя известные вам техники организации кода

// Войска: пехота, конница, лучники.
// Свойства: жизни, броня, урон
$pehota = [
    'health' => 100,
    'armour' => 10,
    'damage' => 10,
];

$luchniki = [
    'health' => 100,
    'armour' => 5,
    'damage' => 20,
];

$konnica = [
    'health' => 300,
    'armour' => 30,
    'damage' => 30,
];

// Создаём две армии (кол-во юнитов)
$army1 = [
    'name' => 'Александр Ярославич',
    'units' => [
        'pehota' => 200,
        'luchniki' => 30,
        'konnica' => 15,
    ]
];
$army2 = [
    'name' => 'Ульф Фасе',
    'units' => [
        'pehota' => 90,
        'luchniki' => 65,
        'konnica' => 25,
    ]
];

// Запускаем битву.
$damage1 = 0;
$health1 = 0;
foreach ($army1['units'] as $unit => $count) {
    $damage1 += $unit['damage'] * $count;
    $health1 += $unit['health'] * $count + $unit['armour'] * $count;
}

$damage2 = 0;
$health2 = 0;
foreach ($army2['units'] as $unit => $count) {
    $damage2 += $unit['damage'] * $count;
    $health2 += $unit['health'] * $count + $unit['armour'] * $count;
}

//function calc_army_damage_health ($army)
//{
//    $damage = 0;
//    $health = 0;
//
//    foreach ($army['units'] as $unit => $count) {
//        $damage += $unit['damage'] * $count;
//        $health += $unit['health'] * $count + $unit['armour'] * $count;
//    }
//
//    return ['damage' => $damage, 'health' => $health];
//};

?>

    <table border="1">
        <tr>
            <th></th>
            <th><?=$army1['name']?></th>
            <th><?=$army2['name']?></th>
        </tr>
        <tr>
            <th>Army units:</th>
            <td>unit1 (count), unit2(count), ...</td>
            <td>unit1 (count), unit2(count), ...</td>
        </tr>
        <?php
        $duration = 0;
        while ($health1 >= 0 && $health2 >= 0) {
            $health1 -= $damage2;
            $health2 -= $damage1;
            $duration++;
        }
        ?>
        <tr>
            <th>Health after <?=$duration?> hits:</th>
            <td><?=$health1?></td>
            <td><?=$health2?></td>
        </tr>
        <tr>
            <th>Result</th>
            <td><?=$health1 > $health2 ? 'WINNER' : 'LOOSER'?></td>
            <td><?=$health2 > $health1 ? 'WINNER' : 'LOOSER'?></td>
        </tr>
    </table>
<?php

// + ДЗ
// Вывод: результаты битвы. Кто участвовал, кто победил, погибшие, выжившие.
// Переписать на ООП, используя интерфейс Unit от которого будут создаваться юниты.
// Научить объединяться юниты в армию, см. Composite
// реализовать две механики расчета боя (суммарный подсчет, сражение каждой линии до выживания)
// добавить условия поля битвы ??? например, лед - снижает броню конницы до 0, дождь - снижает в два раза атаку лучников

// + 3 задачки на codewars

// Паттерны
// https://refactoring.guru/ru/design-patterns/php
// + изучить паттерны Composite Decorator Strategy (самостоятельно)

// MVC - фреймворк, CMS
// https://ru.wikipedia.org/wiki/Model-View-Controller

//
?>


































<!--    <input type="text" class="ttt">-->
<!---->
<!--<p onclick="xyeta()" class="jfghgfd">Click me</p>-->
<!--    </form>-->
<!---->
<!--    <script>-->
<!--        let inp = document.querySelector('.ttt')-->
<!--        let xyeta123 = document.querySelector('.jfghgfd')-->
<!--        function xyeta() {-->
<!--            inp.value = '123'-->
<!--        }-->
<!---->
<!--    </script>-->

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/main.css">
<!--<script>-->
<!--    let parent = document.querySelector('.parent-wrap')-->
<!--    let sub = document.querySelector('.sub-wrap')-->
<!---->
<!--    parent.onmouseover = function(e) {-->
<!--        // sub.style.display = 'block'-->
<!--        //console.log(123)-->
<!--    }-->
<!--</script>-->
<!--<form action="array.php" method="post">-->
<!--    <input type="text" name="number">-->
<!--    <input type="submit">-->
<!--</form>-->
<?php

$_SESSION['name'] = 'Nikita';

trait someFunc
{
    public function some()
    {
        echo 123;
    }
}



class dick
{
    use someFunc;
}

new dick();




































die;




//   interface Product
//   {
//       public function operation() : string;
//   }
//
//    abstract class Creator
//    {
//        abstract function chooseMethod(): Product;
//
//        public function someOperation(): string
//        {
//            $product = $this->chooseMethod();
//            $result = 'Method: '.$product->operation();
//            return $result;
//        }
//    }
//    class ConcreteCreator1 extends Creator
//    {
//
//        public function chooseMethod(): Product
//        {
//            return new ConcreteProduct1();
//        }
//    }
//
//    class ConcreteCreator2 extends Creator
//    {
//
//        public function chooseMethod(): Product
//        {
//            return new ConcreteProduct2();
//        }
//    }
//
//    class  ConcreteProduct1 implements Product
//    {
//        public function operation(): string
//        {
//            return '1';
//        }
//    }
//
//    class  ConcreteProduct2 implements Product
//    {
//       public function operation(): string
//        {
//            return '2';
//        }
//    }
//
//    function clientCode(Creator $creator)
//    {
//        echo $creator->someOperation();
//    }
//
//
//    clientCode(new ConcreteCreator1());
//    echo "<br>";
//    clientCode(new ConcreteCreator2());
//
//



















die;


$arr = [1, 5, 3, 5, 6, 7, 8, 9, 25, 24, 18, 26, 55,  27, 2, 29, 30, 31,
    1, 2, 4, 2, 3, 4, 1, 2, 5, 3, 8, 4, 3, 9, 27, 21, 15,
    14, 19, 44, 18, 22, 10, 1, 4, 43, 91, 9, 6, 9, 89,
    66, 44];

    $b = [];

        for($i = 0;$i < count($arr);$i++)
        {

            $b[$arr[$i]]++;
        }



//    foreach ($arr as $key => $val)
//    {
//        $b[$val]++;
//    }
    print_r($b);


//    foreach ($b as $k => $v)
//    {
//        echo 'Элемент: '.$k.' Количество повторений: '.count($val);
//    }





























die;
$arr = [1, 5, 3, 5, 6, 7, 8, 9, 25, 24, 18, 26, 55,  27, 2, 29, 30, 31,
    1, 2, 4, 2, 3, 4, 1, 2, 5, 3, 8, 4, 3, 9, 27, 21, 15,
    14, 19, 44, 18, 22, 10, 1, 4, 43, 91, 9, 6, 9, 89,
    66, 44];

$arrCount = 1;
$match = 0;
$count = [1,3,2,4];

$result = [];


    for($i=1;$i <= $arrCount;$i++)
    {
        if($arr[$i] == '')
        {
            break;
        }
        $arrCount++;
    }

    echo $arrCount;
    echo count($arr);
#$arr = ['http://google.com', 'sdsaf', 'http://yandex.ru'];

    #echo $sum;
    #echo $max;
    #print_r($newArr);


die;








    #print_r($key);


// $num = (string)99432;
// str_split($num);
//
//    for ($i=0;$i <= strlen($num);$i++)
//    {
//        $x[] = $num[$i];
//    }
//
//
//print_r($x);

































//    for($i=0;$i<count($arr);$i++)
//    {
//        if ($arr[$i] >= $max) $max = $arr[$i];
//    }

    #echo $max;





















       /* $current =1;$sum = 1;$past = 1;
        for($i = 1;$i < 10;$i++)
        {
            $sum = $current + $past;
            $past = $current;
            $current = $sum;
        }

        echo $sum;*/

    #print_r($arr);












//
//function srt($arr)
//{
//    if(count($arr) <= 0)
//    {
//        return $arr;
//    }
//
//    $greater = $less = [];
//
//    for($i = 1;$i < count($arr);$i++)
//    {
//        if($arr[0] < $arr[$i]) $greater[] = $arr[$i];
//        if($arr[0] > $arr[$i]) $less[] = $arr[$i];
//    }
//
//    return array_merge(srt($less), array($arr[0]), srt($greater));
//
//}
//
//
//    print_r(srt($array));



















die;


$id = password_hash(7, PASSWORD_DEFAULT);
$hash = $_COOKIE['id'] = password_hash(1, PASSWORD_DEFAULT);
echo $hash;
$mysql = new mysqli('just', 'mysql', 'mysql', 'resume');
$res = $mysql->query("SELECT * FROM just_table WHERE hash = '$hash'");
$result = $res->fetch_assoc();

if($result !== '')
{
    $hash2 = password_hash(2, PASSWORD_DEFAULT);
    $res = $mysql->query("INSERT INTO `just_table` (hash)
    VALUES ('$hash2') WHERE `hash` = '$hash'");

}

print_r($_COOKIE['session']);



//$_SESSION['data'] = ['id' => 7, 'email' => 'oxxxy@mail.ru'];
//$session_id = session_id();
//
//$_COOKIE['session'] = $session_id;




































die;



function getChaptersSub($id)
{
    $db = new PDO("mysql:host=just;dbname=resume", "mysql", "mysql");
    $sql = "SELECT chapters.id, chapters.name, chapters.color, chapters.parent_id 
    FROM `chapters` INNER JOIN `users` ON chapters.user_id = users.id 
    WHERE chapters.parent_id = ?"; #
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    $array = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $array;
}
function getChaptersAll()
{
    $id = 7;
    $db = new PDO("mysql:host=just;dbname=resume", "mysql", "mysql");
    $sql = "SELECT chapters.id, chapters.name, chapters.color, chapters.section, 
    chapters.user_id, chapters.parent_id
    FROM `chapters` INNER JOIN `users` 
    ON  chapters.user_id = ? WHERE users.id = ?"; #
    $stmt = $db->prepare($sql);
    $stmt->execute([$id, $id]);
    $array = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $array;
}
?>


<!--<ul id="myUL">-->
<!--    <li><span class="caret">Beverages</span>-->
<!--        <ul class="nested">-->
<!--            <li>Water</li>-->
<!--            <li>Coffee</li>-->
<!--            <li><span class="caret">Tea</span>-->
<!--                <ul class="nested">-->
<!--                    <li>Black Tea</li>-->
<!--                    <li>White Tea</li>-->
<!--                    <li><span class="caret">Green Tea</span>-->
<!--                        <ul class="nested">-->
<!--                            <li>Sencha</li>-->
<!--                            <li>Gyokuro</li>-->
<!--                            <li>Matcha</li>-->
<!--                            <li>Pi Lo Chun</li>-->
<!--                        </ul>-->
<!--                    </li>-->
<!--                </ul>-->
<!--            </li>-->
<!--        </ul>-->
<!--    </li>-->
<!--</ul>-->

<script>
    let link = 'https://my-json-server.typicode.com/typicode/demo/db';
    let response = fetch(link)
    let data = response


    console.log(data)


</script>




<?php


function drevoupp($parentId){

    $connect = new mysqli('just', 'mysql', 'mysql', 'resume');
    $query = mysqli_query($connect, "SELECT * from chapters");
    while($row=mysqli_fetch_array($query))
    {
        $title = $row['name'];
        $pid = $row['parent_id'];
        $id = $row['id'];
        if($parentId == $pid)
        {
            echo "<option value='$title'>$title";
                echo "<optgroup>";
                        drevoupp($id);
                echo "</optgroup>";
            echo "</option>";
//            echo "<li><a href=\"#\">$title</a>";
//            echo "<ul>";
//            drevoupp($id);
//            echo "</ul>";
//            echo "</li>";
        }
    }
}

echo '<select>';
drevoupp(0);
echo '</select>';



ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

$array = [1, 54, 2, 3, 3, 1, 2, 98, 4, 3, 4, 1, 7];

class Start_Value
{
    public function value(array $array)
    {
        rsort($array);
        return $array;
    }

}

class Error_Class
{


    public function specific_fun(array $array)
    {
        return $array;
    }
}

class Adapter extends Start_Value
{
    private $error_class;

    public function __construct(Error_class $error_class)
    {
        $this->error_class = $error_class;
    }

    public function value(array $array): array
    {
        sort($array);
        return $array;
    }




}
$obj = new Adapter(new Error_Class());
print_r($obj->value($array));





//$model = new Adapter(new Error_Class);
// $model->start_value($array);

// print_r($obj->start_value($array));


















die;



$data = getChaptersAll();
//$sub = getChaptersSub();

$link = new mysqli('just', 'mysql', 'mysql', 'resume');
$db = new PDO("mysql:host=just;dbname=resume", "mysql", "mysql");


//
///**
// * Целевой класс объявляет интерфейс, с которым может работать клиентский код.
// */
//class Target
//{
//    public function request(): string
//    {
//        return "Target: The default target's behavior.";
//    }
//}
//
///**
// * Адаптируемый класс содержит некоторое полезное поведение, но его интерфейс
// * несовместим с существующим клиентским кодом. Адаптируемый класс нуждается в
// * некоторой доработке, прежде чем клиентский код сможет его использовать.
// */
//class Adaptee
//{
//    public function specificRequest(): string
//    {
//        return ".eetpadA eht fo roivaheb laicepS";
//    }
//}
//
///**
// * Адаптер делает интерфейс Адаптируемого класса совместимым с целевым
// * интерфейсом.
// */
//class Adapter extends Target
//{
//    private $adaptee;
//
//    public function __construct(Adaptee $adaptee)
//    {
//        $this->adaptee = $adaptee;
//    }
//
//    public function request(): string
//    {
//        return "Adapter: (TRANSLATED) " . strrev($this->adaptee->specificRequest());
//    }
//}
//
///**
// * Клиентский код поддерживает все классы, использующие целевой интерфейс.
// */
//function clientCode(Target $target)
//{
//    echo $target->request();
//}
//
//$target = new Target();
//clientCode($target);
//echo "\n\n";
//
//$adaptee = new Adaptee();
//echo "Adaptee: " . $adaptee->specificRequest();
//echo "<br />";
//
//$adapter = new Adapter($adaptee);
//clientCode($adapter);
//
//die;

class Context
{

    private $strategy; #Here we put our method in this variable

    public function __construct(Algorithm $strategy)
    {
        $this->strategy = $strategy; #Here substitute value in variable
    }

    public function setStrategy(Algorithm $strategy)
    {
        $this->strategy = $strategy; #Update var in real time
    }

    public function doSomeBuisnessLogic() : void #Just logic, algorithm
    {
        $result = $this->strategy->doAlg([1, 4, 2, 9, 11, 2, 4, 16, 99, 0, 5]);
        print_r($result);
    }

}

interface Algorithm
{
    public function doAlg(array $arr): array;
}

class Method1 implements Algorithm
{
    public function doAlg(array $arr): array
    {
        if(count($arr) <= 1)
        {
            return $arr;
        }
        $greater = $less = [];
        for($i = 1;$i < count($arr);$i++)
        {
            if($arr[$i] >= $arr[0])
            {
                $greater[] = $arr[$i];
            }
            else
            {
                $less[] = $arr[$i];
            }
            {
            }
        }
        return array_merge($this->doAlg($less), array($arr[0]), $this->doAlg($greater));
    }
}
class Method2 implements Algorithm
{
    public function doAlg(array $arr): array
    {

        for($i = 0;$i < count($arr);$i++)
        {
            for($j = 0;$j < count($arr)-1;$j++)
            {
                if($arr[$j] >= $arr[$j+1])
                {
                    $tmp = $arr[$j+1];
                    $arr[$j+1] = $arr[$j];
                    $arr[$j] = $tmp;

                }
            }

        }
        return $arr;
    }
}

$model = new Context(new Method1());
$model->doSomeBuisnessLogic();
echo "<br />";
$model = new Context(new Method2());
$model->doSomeBuisnessLogic();


























class User
{
    private $name;
    private $email;
    private $pass;
    private $age;

    /**
     * User constructor.
     * @param $name
     * @param $email
     * @param $pass
     * @param $age
     */
    public function __construct($name=null, $email=null, $pass=null, $age=null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->pass = $pass;
        $this->age = $age;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * @param mixed $pass
     */
    public function setPass($pass): void
    {
        $this->pass = $pass;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param mixed $age
     */
    public function setAge($age): void
    {
        $this->age = $age;
    }
}













//class mainSenderService
//{
//    private $driver;
//
//    public function setDriver(string $driver)
//    {
//        $this->driver = $driver;
//    }
//
//    public function send(string $email, string $content) : bool
//    {
//
//    }
//
//}




//$sql="SELECT * FROM chapters WHERE parent_id = 0 AND user_id = 7";
//$stmt = $db->prepare($sql);
//$stmt->execute([0, 7]);
//
//$result = $stmt->fetchAll();
//$sSQL="SELECT * FROM chapters WHERE parent_id = 0 ";
//$result = $link->query($sSQL);
//print_r($result);

//    $arr = [1, 3 ,2, 6, 1, 6, 3, 9, 44, 3, 21];
//
//
//   for($i = 0;$i < count($arr);$i++)
//   {
//       for($j = 0;$j < count($arr)-1;$j++)
//       {
//           #echo $i.' ';
//            if($arr[$j] >= $arr[$j+1])
//            {
//                $tmp = $arr[$j];
//                $arr[$j] = $arr[$j+1];
//                $arr[$j+1] = $tmp;
//
//
//            }
//       }
//   }
//
//
//
//    print_r($arr);




die;

function ShowTree($ParentID, $lvl) {

    global $link;
    global $lvl;
    $lvl++;

    $sSQL="SELECT * FROM chapters WHERE parent_id = '$ParentID' ";
    $result = $link->query($sSQL);

    if (mysqli_num_rows($result) > 0) {
        echo("<optgroup class='parent_ul_$lvl'>");
        while ( $row = mysqli_fetch_array($result) ) {
            $ID1 = $row["id"];
            echo("<option style='color: ".$row['color']."' class='parent_li' >");
            echo("<a href=\""."?ID=".$ID1."\">".$row["name"]."</a>");



            ShowTree($ID1, $lvl);
            $lvl--;

        }

        echo("</optgroup>");
    }

}
?>

<select name="" id="">
    <?php ShowTree(0, 0);?>
</select>

<?php


die();

    function returnMenu($data)
    {

        echo "<ul>\n\t";
            foreach ($data as $key => $val)
            {
                if(is_array($val))
                {
//                    foreach (getChaptersSub($val['id']) as $v)
//                    {
                    foreach ($val as $item)
                    {
                        if($val['id'] == $item)
                        {
                            echo $item;
                        }
                    }

//                    }

//                    if($val['section'] == 1)
//                    {
//                        echo "<li><b>".$val['name']."</b>";
//                    }
//                    if($val[''])

                    returnMenu($val);
                }
//                else
//                {
////                    echo "<li>".$key.': '.$val;
//                    if($key == 'section')
//                    {
//                        echo "<li><b>$val</b>";
//                    }

//                    else
//                    {
//                        echo "<li>$val</li>";
//                    }

                }
//            }

        echo "</ul>";

    }

    echo returnMenu($data);



//$conn = new mysqli('just', 'mysql', 'mysql', 'resume');
////$conn = new PDO('mysql:host=just;dbname=resume', 'mysql', 'mysql');
//
//function rec($array = array(), $conn) {
//
//    foreach ($array as $value) {
//        $query = "SELECT parent_id FROM chapters where parent_id = {$value[0]}";
//        $res = $conn->query($query);
//        while ($data = $res->fetch_row()) {
//            $result[] = $data;
//        }
//        if (is_array($result)) {
//            return $result[] = rec($result, $conn);
//        } else {
//            return;
//        }
//    }
//}
//$query = "SELECT id FROM chapters where parent_id = 0";
//$res = $conn->query($query);
//while ($data = $res->fetch_row()) {
//    $result[] = $data;
//}
//print_r($result);
//print_r(rec($result, $conn));
//






























require 'Controllers\JustController.php';
$messages = new JustController();
require 'Google\Users.php';

//function getChaptersAll()
//{
//    $id = 7;
//    $db = new PDO("mysql:host=just;dbname=resume", "mysql", "mysql");
//    $sql = "SELECT chapters.id, chapters.name, chapters.color, chapters.parent_id
//    FROM `chapters` INNER JOIN `users`
//    ON  chapters.user_id = ? WHERE users.id = ?"; #
//    $stmt = $db->prepare($sql);
//    $stmt->execute([$id, $id]);
//    $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
//
//    return $array;
//}
        
//function getChaptersSub($id)
//{
//    $db = new PDO("mysql:host=just;dbname=resume", "mysql", "mysql");
//    $sql = "SELECT chapters.id, chapters.name, chapters.color, chapters.parent_id
//    FROM `chapters` INNER JOIN `users` ON chapters.user_id = users.id
//    WHERE chapters.parent_id = ?"; #
//    $stmt = $db->prepare($sql);
//    $stmt->execute([$id]);
//    $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
//
//    return $array;
//}
        echo "<br />";

 foreach(getChaptersAll() as $val)
 {
     foreach($val as $key => $val) 
     {
         #echo $val; 
         if($key == 'color') $colors[] = $val;
         elseif($key == 'name') $names[] = $val;
         elseif($key == 'id') $ids[] = $val;
     }
 }
 $chapterAll = getChaptersAll();
print_r($chapterAll);
    $full['colors'] = $colors;
    $full['names'] = $names;
    $full['ids'] = $ids;
     //print_r($ids);
    // print_r($names);
    foreach(getChaptersSub($ids[1]) as $val){
            echo $val;
    }

    for($i=0;$i<count($ids);$i++)
    {
         if(getChaptersSub($ids[$i]) != null)
         {
             $news[] = getChaptersSub($ids[$i]);
         }
         else {continue;}   
    }
    echo '<br>';
    //print_r($full);

    $megarray = array_combine($names, $colors);

        function recurse($chapterAll)
        {
//            if ()


        }

$graph = [
    'A' => ['B', 'C', 'D'],
    'B' => ['G', 'H'],
    'C' => ['G'],
    'D' => ['E', 'F'],
    'E' => [],
    'F' => [],
    'G' => [],
    'H' => []
];
$startNode = 'A';
$endNode   = 'H';

$searchQueue = [];
$searched    = [];

foreach($graph[$startNode] as $value) {
    echo $value;
    $searchQueue[] = $value;
}

while($searchQueue) {
    $node = array_shift($searchQueue);

    if(!in_array($node, $searched)) {
        if($node === $endNode) {
            echo 'Целевая точка найдена';
            die();
        } else {
            foreach($graph[$node] as $value) {
                $searchQueue[] = $value;
            }

            $searched[] = $node;
        }
    }
}

echo 'Целевая точка не найдена';

//$menu = array('user_id' => 7, 'name' => 'Основные');
//
//// Помещаем корневой элемент меню в очередь
//$queue = array(&$menu);
//
//$i = 0;
//while (count($queue) > $i)
//{
//    // Извлекаем элемент из очереди и делаем его текущим
//    $elem = &$queue[$i++];
//
//    // Загружаем подменю текущего элемента
//    $res = mysqli_query('SELECT id, name FROM menuTable WHERE link='.$elem['id']);
//
//    // Заполняем подменю текущего элемента
//    while ($row = mysqli_fetch_assoc($res))
//    {
//        if (!isset($elem['subMenu']))
//            $elem['subMenu'] = array();
//
//        $elem['subMenu'] []= array('id' => $row['id'], 'name' => $row['name']);
//
//        // Добавляем элемент подменю в очередь на загрузку из БД
//        $queue []= &$elem['subMenu'][count($elem['subMenu']) - 1];
//    }
//}
//
//var_dump($menu);

            ?>
<style>
    li {
        list-style: none;
    }
</style>
<?php //for($i = 0;$i < count($val);$i++):?>
<!---->
<?php //endfor;?>

<?php foreach ($chapterAll as $key => $val):?>
    <div class="wrapper">
        <?php if($val['parent_id'] == 0 ):?>
        <ul>    <h2><?=$val['name']?></h2>
            <li>

            </li>
        </ul>
        <?php endif;?>
    </div>

<?php endforeach;?>
<br><br><br><br>


            <form class="d-flex flex-column" action="http://zenden/add/chapter" method="post">

      <select class="user-wall-input" name="parent_chapter" id="">
<!--          <option value="Родительский раздел" disabled>Родительский раздел</option>-->

     <option value="none" >Новый раздел</option>
<!--          <optgroup label="--><?//=$val['name']?><!--">-->
<!---->
<!--              <option value="--><?//=$val['id']?><!--">В этом разделе</option>-->


<?php foreach ($chapterAll as $key => $val):?>

<?php if($val['parent_id'] == '' || $val['parent_id'] == $val['id']):?> #Некорректная, нарушает вложенность!
      <optgroup label="<?=$val['name']?>">

          <option value="<?=$val['id']?>">В этом разделе</option>

<?php endif;?>

                #Здесь должен быть цикл для перебора val['id']
<!--                --><?php //foreach ($val as $k => $v):?>
<!--                      --><?php //if($k === 'name'):?>
<!--                        <option value="">--><?//=$v?><!--</option>-->
<!---->
<!--<!--                        <option value="">-->--><?////=$val['name']?><!--<!--</option>-->-->
<!---->
<!--                      --><?php //endif;?>
<!--                --><?php //endforeach;?>

                </optgroup>

<!--              <p>--><?//=$val['id']?><!--</p>-->

          <?php endforeach;?>




<!--          --><?php //foreach ($chapterAll as $key => $val):?>
<!---->
<!--              --><?php //if($val['parent_id'] == ''):?>
<!--                  <optgroup label="--><?//=$val['name']?><!--">-->
<!---->
<!--                  <option value="">В этом разделе</option>-->
<!---->
<!--              --><?php //else:?>
<!--                  --><?php //foreach ($val['id'] as $v):?>
<!--                      --><?php //if($val['parent_id'] == $v):?>
<!---->
<!--                          <option label="--><?//=$val['name']?><!--"></option>-->
<!---->
<!--                      --><?php //endif;?>
<!--                  --><?php //endforeach;?>
<!--                  </optgroup>-->
<!--                  <!--                  <option value="">-->--><?////=$val['name']?><!--<!--</option>-->-->
<!---->
<!--              --><?php //endif;?>
<!--              <!--                        <option value="">-->--><?////=$val['color']?><!--<!--</option>-->-->
<!--          --><?php //endforeach;?>
<!--          -->









<!--          <optgroup label="">-->
<!---->
<!--          </optgroup>-->

 </select>

 <input class="user-wall-input" type="text" name="chapter_name" placeholder="Название раздела">
 <input class="user-wall-input" type="text" name="color" placeholder="Цветной маркер раздела">
 <input class="btn btn-dark btn-chapter" type="submit" value="Создать">

  </form>


  <?php
        

  // foreach($array as $val)
        // {
        //     $color[$val['color']] = $val['color'];
        //     $name[$val['name']] = $val['name'];
        // }
        // $result = array_combine($name, $color);

// // $_SESSION['message_new_user_success'] = 'Message';
// $_SESSION['message_new_user_success'] = 'success';
// $_SESSION['message_new_user_warning'] = 'warning';
// $_SESSION['message_new_user_danger'] = 'danger';

//     foreach ($_SESSION as $key => $val) {
//         if(preg_match('/message/', $key)) {
//             echo 'Yes'."<br />";
//         }
//         else {
//             echo 'No'."<br />";
//         }
//     }
$messages->getIncomingMessages();

print_r($messages->getIncomingMessages());
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width">
<!--    <link rel="stylesheet" type="text/css" href="style/style.css">-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">


</head>
<body>

<div class="signup-block">
</div>


<section>
<h3 class="text-center">Входящие Cообщения</h3>



<!--        <article>-->
<!--            <h3>Непрочитанные сообщения</h3>-->
<!---->
<!--        </article>-->
<!--        <article>-->
<!--            <h3>Прочитанные сообщения</h3>-->
<!---->
<!--        </article>-->
</section>

<br />
<br />
<br />

   <?php
   //$messages->outputMessagesSuccess();
//    $messages->outputMessagesWarning();
//    $messages->outputMessagesDanger();
























   echo "<br />";

   //


   spl_autoload_register(function ($class) {
       $path = str_replace('\\', '/', $class.'.php');
       //echo $path = $class.'.php';
       if(file_exists($path))
       {
           require $path;
       }
       else {
           echo '404';
       }

   });
   $controller = new JustController();
   $controller->firstAction();

   //    if (method_exists($controller, 'firstAction'))
   //    {
   //     echo 'Yes';
   //    }
   //    else
   //    {
   //     echo 'No';
   //    }


   //



$array = [1, 5, 3, 5, 6, 7, 8, 9, 25, 24, 18, 26, 55,  27, 2, 29, 30, 31, 1, 2, 4, 2, 3, 4, 1, 2, 5, 3, 8, 4, 3, 9, 27, 21, 15,
14, 19, 44, 18, 22, 10, 1, 4, 43, 91, 9, 6, 9, 89,
66, 44, 76, 54, 84, 46, 61, 34, 57, 81, 49, 51, 34, 65, 75, 35, 39, 89, 91, 96, 34, 51, 20, 41, 31, 111, 22, 41, 223, 221,
44, 58, 91, 90, 43, 133, 411, 433, 612, 334, 31, 32, 57, 52, 79,
70, 60, 40, 41, 57, 51, 44, 99];

    function Update ($arr)
    {
        if(count($arr) > 1) {
            return $arr;
        }

        $greater = $less = [];

        for($i = 0;$i < count($arr);$i++)
        {
            if($arr[$i] < $arr[0])
            {
                 $less = $arr[$i];
            }
            else {
                $greater = $arr[$i];
            }
        }
        return array_merge(Update($less), array($arr[0]), Update($greater));

    }

    print_r(Update($array));




    echo "<br />";

    // function SumOfArray($array) {

    //      $arrCount = 0;
    //      for($i=0;$i < $arrCount+1;$i++) {

    //          if ($array[$i] == ''){
    //              break;
    //          }
    //          $array[$i] = '';
    //          $arrCount++;
    //      }

    //     echo $arrCount;
    // }

   //require 'Controller\JustController.php';




$array = [1, 5, 3, 5, 6, 7, 8, 9, 25, 24, 18, 26, 55,  27, 2, 29, 30, 31, 1, 2, 4, 2, 3, 4, 1, 2, 5, 3, 8, 4, 3, 9, 27, 21, 15,
14, 19, 44, 18, 22, 10, 1, 4, 43, 91, 9, 6, 9, 89,
66, 44, 76, 54, 84, 46, 61, 34, 57, 81, 49, 51, 34, 65, 75, 35, 39, 89, 91, 96, 34, 51, 20, 41, 31, 111, 22, 41, 223, 221,
44, 58, 91, 90, 43, 133, 411, 433, 612, 334, 31, 32, 57, 52, 79,
70, 60, 40, 41, 57, 51, 44, 99];



    $i=1; $r=1; $l=1; $s=1;
    while($i++ < count($array) / 2) {   //Фиббоначи
    $s=$l+$r;
    $l=$r;
    $r=$s;
    $x[] = $s;

    }
    for($i=0;$i < count($array);$i++){ //поиск совпадений

        for($j = 0;$j < count($array);$j++) {
            if ($array[$i] == $x[$j]) {
                $result[] = $array[$i];
            }
    }
        }
        $y = [];
        foreach($result as $val) { // для удобства убираем повторяющиеся элементы массива
            $y[$val][] = $val;
        }
        foreach($y as $key => $val) {
            $final[] = $key;
        }

        sort($final);

        var_dump($final);






//  echo (F($array));




















    // function Binary ($arr, $val) {
    //     if (!$arr) {
    //         $left = $arr[0];
    //         $right = array_key_last($arr)-1;


    //     while ($left <= $right) {
    //         $middle = $left + ($right - $left)/2;

    //         if ($arr[$middle] == $val) {
    //             return $middle;
    //         }

    //         if ($value < $arr[$middle]) {
    //             $right = $middle - 1;
    //         }
    //         else {
    //             $left = $middle + 1;
    //         }

    //     }
    // }
    // return null;
    // }

    // echo Binary($array, 1);








    // $b = [];

    // foreach($array as $v) {
    //     $b[$v][] = $v;
    // }

    // // print_r($b);
    // foreach($b as $key => $val) {
    //     if(count($val) % 2 == 0){
    //         $x[] = $key;
    //         if(SumOfArray($val) > SumOfArray($val+1)) {
    //             $max = $val;
    //         }
    //         else {
    //             $max = $val+1;
    //         }
    //     }
    // }


    // echo $max;
    // print_r($x);












    // function Recurs($val) {
    //     if ($val <= 1) return 1;
    //     return $val * Recurs($val-1);

    // }

    // echo Recurs(4);

    echo "<br />";
        // $arr = [1,2,3,4,5,6,7,8,9,1,2];
        // $arrCount = 0;
        // for($i=0;$i < $arrCount+1;$i++) {
        //     echo $arr[$i];
        //     if ($arr[$i] == ''){
        //         break;
        //     }
        //     $arr[$i] = '';
        //     $arrCount++;
        // }

echo "<br />";
//echo $arrCount;
echo "<br />";









$array = array(1, 0, 6, 9, 4, 5, 2, 3, 8, 7, 10, 11, 99, 10); // исходный массив

// перебираем массив
for ($j = 0; $j < count($array) - 1; $j++){

for ($i = 0; $i < count($array) - 1; $i++){
// если текущий элемент больше следующего
if ($array[$i] > $array[$i + 1]){
// меняем местами элементы
$tmp_var = $array[$i + 1];
$array[$i + 1] = $array[$i];
$array[$i] = $tmp_var;

}
}
}

// вывод результата
print_r($array);

echo "<br>";

$arr = [ 4, 9, 6, 2, 10, 9, 11];

    $numbers = '44214612';

        $num = 5;

//  function SortArrFr ($arr) {
//     $countArr = count($arr);
//      if ($countArr <= 1) {
//         return $arr;
//      }

//      $greater = $less = [];

//      for ($i = 1;$i < $countArr;$i++) {
//      if ($arr[$i] <= $arr[0]) {
//           $less[] = $arr[$i];
//         }
//       else {
//         $greater[] = $arr[$i];

//       }
//      }

//      return array_merge(SortArrFr($less),
//      array($arr[0]), SortArrFr($greater));


//  }

//     print_r(SortArrFr($arr));

          //print_r($arr);

        // $arr2 = str_split($number, 1);

        //     foreach($arr2 as $v) {
        //         $b[$v][] = $v;
        //     }


        //     foreach($b as $k => $v) {

        //         if(count($v) > 1) {
        //             $result[] = $k;
        //         }

        //     }
        //     print_r($result);


//     for($i = 0;$i < strlen($number);$i++) {

//         for($j = 0;$j < strlen($number);$j++) {

//             if($number[$i] == $number[$j]) {
//                 $num[$number[$i]][] = $number[$j];
//             }

//         }

// }
//  print_r($num);









            // foreach ($arr as $k => $v) {
            //     $sum = $v;
            // }
            // echo $sum;

            //    for($i = 0;$i < count($arr) - 1;$i++) {

            //         for($j = 0;$j < count($arr) - $i - 1;$j++) {
            //             if($arr[$j] > $arr[$j+1]) {
            //             echo $arr[$j];
            //             echo "<br>";
            //             $nextEl = $arr[$j+1];
            //             $arr[$j+1] = $arr[$j];
            //             $arr[$j] = $nextEl;
            //             echo $arr[$j]."<hr>";
            //         }
            //    }
            // }

            // print_r($arr);


echo "<br />";
// $products = [
//     ['id' => 1, 'name' => 'Товар 1', 'price' => 1000],
//     ['id' => 2, 'name' => 'Товар 2', 'price' => 500],
//     ['id' => 3, 'name' => 'Товар 3', 'price' => 2000],
//     ['id' => 4, 'name' => 'Товар 4', 'price' => 300]
// ];

// function mySort($a, $b) {
//     if($a['price'] == $b['price'])
//         return 0;

//     if($a['price'] < $b['price'])
//         return -1;
//     else
//         return 1;
// }

// usort($products, 'mySort');


                $hash = (object) array('str' => 'Word');
                echo $hash->str;

        $arr = [1, 4, 9, 1, 6, 2, 10, 9, 11];

        for($i = 0;$i < count($arr);$i++) {
            //$i - выводит 1 элемент массива
               # echo 'Номер: '.$arr[$i]."<br>";
            for ($j = $i;$j < count($arr);$j++) {
            //$j - выводит сразу все элементы массива, внутри $i
               # echo $arr[$i] * $arr[$j].'<br>';
            }
        }
        function Mult ($arr) {

                    if (count($arr) == 1) {
                        return $arr[0] * $arr[0];
                    }elseif (count($arr) == 0) {
                        return $arr;
                    }

                    for($i = 0;$i < count($arr);$i++) {
                            $x = $i;
                    }

                    return Mult($arr[$x]) * Mult($arr[$x+1]);
            }

            echo Mult($arr);






               // echo Mult($arr);

            // function OutVal ($arr, $i) {
            //     if (count($arr) < 2){
            //         return $arr;
            //     }

            //     return OutVal($arr[$i], $i+1);

            // }

            // echo OutVal($arr, 1);






// function F($n){
//     $i=1; $r=1; $l=1; $s=1;
//     while($i++<$n){
//     $s=$l+$r;
//     $l=$r;
//     $r=$s;
//     }
//     return $s;
//     }


        $arr = [0, 4, 9, 1, 6, 2, 10, 9, 11];
        // foreach ($arr as $k => $v) {
        //     ($v > $arr[$k++]) ? $max = $v : $max = $v;
        // }
        //echo $max;

        // function BiggestNum ($array, $i) {

        //         if($i > count($array)) return 1;

        //         //return BiggestNum($array, $i+1);
        //             if ($array[$i] > BiggestNum($array, $i+1)) {
        //                 return $max = $array[$i];
        //             }
        //             if($array[$i] > $max) {
        //                 return $max = $array[$i];
        //             }

        //             return $max;
        // }
        //         //return F($n-1)+F($n-2);
        // echo BiggestNum($arr, 1);


        // foreach ($arr as $k => $v) {


        //     if ($v > $arr[$k++]) {
        //         $max = $v;
        //     }
        //     if($v > $max) {
        //         $max = $v;
        //     }
        // }
        // echo $max;



    // function F($array){
    // if($n <= 1){
    // return 1; //Вывести значение
    // }
    // return F($n-1)+F($n-2);
    // }
    // //return F($n-1)+F($n-2);

    // echo F(20);


    // $arr = [0, 4, 9, 1, 6, 2];


    // function fact ($array, $i) {

    //     //if (count($array) <= 0) return 1;

    //         return $array[$i] + fact($array[$i+1]);


    // }


    // echo fact($arr, 1);



    echo "<br />";
// function fact($n) {
//     if ($n <= 0) return 1;
//     return $n * fact ($n-1);
// }
// echo fact(4);

// function sortMyself ($arr) {
//     $arrayCount = count($arr);

//     if ($arrayCount <= 1) {
//         return $arr;  //Определяем базовый случай
//     }

//         $greater = [];
//         $less = [];

//         for ($i = 1;$i < $arrayCount;$i++) {
//         if ($arr[$i] <= $arr[0]) {
//             $less[] = $arr[$i];
//         } else {
//             $greater[] = $arr[$i];
//         }
//        }
// return array_merge(sortMyself($less), array($arr[0]), sortMyself($greater));
//   }
//         print_r(sortMyself($arr));















  // foreach ($arr as $v) {
    //     $sum += $v;

    // }
    // echo $sum;

















// $array = [1, 5, 3, 5, 6, 7, 8, 9, 25, 24, 18, 26, 27, 2, 29, 30, 31, 1, 2, 4, 2, 3, 4, 1, 2, 5, 3, 8, 4, 3, 9, 27, 21, 15,
//  14, 19, 44, 18, 22, 10, 1, 4, 43, 91, 9, 6, 9
// , 66, 44, 76, 54, 84, 46, 61, 34, 57, 81, 49, 51, 34, 65, 75, 35, 39, 89, 91, 96, 34, 51, 20, 41, 31, 111, 22, 41, 223, 221,
//  44, 58, 91, 90, 43, 133, 411, 433, 612, 334, 31, 32, 57, 52, 79,
// 70, 60, 40, 41, 57, 51, 44, 99];

// $b = [];
// // sort($array);


//     foreach ($array as $arr) {
//         $b[$arr][] = $arr;
//     }

//     foreach ($b as $key => $val) {

//         if (count($val) % 2 == 0) {

//             //echo "Элемент ".$key." повторяется столько раз: ".count($val)."<br>";
//             echo $key."<br>";

//         }

//     }


//Выводим последовательные повторяющиеся пары чисел




//   $a = "Длина тела — до 2 м, чаще 1—1,5 м. Максимальная масса 57,7 кг[2]. Тело голое, покрытое многочисленными кожистыми выростами и костными бугорками. По обеим сторонам головы, по краю челюсти и губ свисают бахромой клочья кожи, шевелящиеся в воде, словно водоросли, что делает его малозаметным на грунте.

// Туловище приплюснутое, сжатое в спинно-брюшном направлении. Голова плоская, широкая, сплющенная сверху. Рот большой, полукруглый, с выступающей вперёд нижней челюстью и острыми крючковатыми зубами. Глаза маленькие.

// Жаберные отверстия широкие, расположены под основаниями грудных плавников. Мягкая кожа без чешуи; обильная кожная бахрома по краю туловища.";





//   $link2 = 'https://ru.wikipedia.org/wiki/Европейский_удильщик';
//   $a2 = mb_substr($a, 0, 180);

//   $array = explode(' ', $a2);
//   $countArr = count($array);

//   function lastTwoElements($array){

//       $arrReverse = array_reverse($array);
//       $complete = [$arrReverse[1], $arrReverse[0]]; #Разворачиваем массив в другую сторону и получаем эти два слова
//       return $complete;

//   }

//   function allElements($array){

//       array_pop($array);
//       array_pop($array);

//       return $array;
//   }

//   $arrayLast = implode(' ', allElements($array));
//   $arrayTwoEl = implode(' ', lastTwoElements($array));

//   $lastTwoElWithLink = "<a href='$link2'>$arrayTwoEl...</a>"; #Добавляем ссылку на последние два слова

//   $b = $arrayLast.' '.$lastTwoElWithLink; #Объединение всего предложения с последними двумя словами ссылкой
//   echo $b;



    // function Name ($name, $surname, $i) {
    //         echo 'Hello, '.$name;

    //         Surname($surname);
    //         Bye();



    //             if ($i < 10) {
    //                 Name('Nikita', 'Potorokin', $i + 1);
    //             }

    //         }





    // function Surname($surname) {
    //     echo " ".$surname.', ';
    // }

    // function Bye () {
    //     echo ' Bye!';
    // }


    // Name('Nikita', 'Potorokin', 1)























  $arr = [4, 4, 4, 22, 314, 49, 10, 18, 291, 99];

//   function sortMyself ($arr) {
//       $arrayCount = count($arr);

//       if ($arrayCount <= 1) {   //Определяем базовый случай
//           return $arr;
//       }

//       $greater = [];
//       $less = [];

//       for ($i = 1;$i < $arrayCount;$i++) {
//       if ($arr[$i] <= $arr[0]) {
//           $less[] = $arr[$i];
//       } else {
//           $greater[] = $arr[$i];
//       }
//      }
//     return array_merge(sortMyself($less), array($arr[0]), sortMyself($greater));

//     }
//    print_r(sortMyself($arr));























   ?>























<!--<form action="reg.php" method="post">

    <input type="text" id="name" name="login">
    <label for="name">Login</label>
    <br />
    <br />
    <input type="password" id="pass" name="password">
    <label for="pass">Password</label>
    <br />
    <br />
    <input type="submit">
</form>-->

<!-- Сначала перебрать каждый элемент, если совпадений нет, то в один массив,
если есть, то в другой а после объединить -->

</body>

<?php


















    // $array = [26, 17, 136, 12, 79, 15];

    //     foreach ($array as $arr) {
    //          //$square[] = $arr * $arr;
    //             $sum += $arr * $arr;
    //     }

    //     print_r($sum);














$a = "Длина тела — до 2 м, чаще 1—1,5 м. Максимальная масса 57,7 кг[2]. Тело голое, покрытое многочисленными кожистыми выростами и костными бугорками. По обеим сторонам головы, по краю челюсти и губ свисают бахромой клочья кожи, шевелящиеся в воде, словно водоросли, что делает его малозаметным на грунте.

Туловище приплюснутое, сжатое в спинно-брюшном направлении. Голова плоская, широкая, сплющенная сверху. Рот большой, полукруглый, с выступающей вперёд нижней челюстью и острыми крючковатыми зубами. Глаза маленькие.

Жаберные отверстия широкие, расположены под основаниями грудных плавников. Мягкая кожа без чешуи; обильная кожная бахрома по краю туловища.";

# substr - выделяет символы, а не слова, обрезать и поставить ссылку на два последних целых слова можно только в списке или массиве,
# длину которого динамически будет определить накладно да и незачем
# если обрезать текст при помощи sub_str, и какое-то слово с кириллицей не полностью влезло,
# то будет появляться спец. символ �, поэтому использую mb_substr
# минусом огренечения по количеству символов является не полное помещение слова, оно просто обрезается


#Я сделал два варианта решения этой задачи
# Первый он более простой и не всегда корректно делает обрезку по символам
# Второй же вариант перебирает весь текст и переобразовывает слова в элементы массива
# после чего последние два элемента помещает в ссылку



#Я сделал 2 варианта:

#В 1 мы получаем в итоге изображение 200 на 100 пикселей, но оно будет обтянутым
#В 2 мы получаем изображение, где высота регулирется за счет деления

#В этом задании невозможно получить полное изображение не перетянутым,
#можно приблизить картинку, но тогда некоторые детали фотографии будут упущены

#Я считаю, что подобные моменты лучше регулировать при помощи html/css

// function countCon($ar, $n)

// {
//     $cnt = 0;

//     for ($i = 0; $i < $n - 1; $i++)

//     {
//         if ($ar[$i] == $ar[$i + 1])

//             $cnt++;

//     }
//     return $cnt;

// }
// $ar = array(3, 12, 44, 3, 4, 44, 9, 6, 9);

// $n = count($ar);

// echo countCon($ar, $n);

#here
/*$link1 = 'https://ru.wikipedia.org/wiki/Европейский_удильщик';
    $c1 = mb_substr($a, 0, 180);
    $d1 = mb_substr($a, 180, 16).'...';
    $b1 = $c1."<a href='$link1'>$d1</a>";
    echo $b1;

    echo "<br />";

    $link2 = 'https://ru.wikipedia.org/wiki/Европейский_удильщик';
    $a2 = mb_substr($a, 0, 180);

    $array = explode(' ', $a2);
    $countArr = count($array);

    function lastTwoElements($array){
        for($i = count($array);$i > count($array)-3;$i--) { #Выбираем два последних элемента из массива
        $el1[] = ' '.$array[$i]; #Да, там написано -3, а не -2, потому что с -2 выделяет только 1 слово

    }
        return array_reverse($el1);
    }

    function allElements($array){
         array_pop($array);array_pop($array); #Получаем массив без двух последних элементов
         return $array;
    }


    $arrayLast = implode(' ', allElements($array));
    $arrayTwoEl = implode(' ', lastTwoElements($array));

    $lastTwoElWithLink = "<a href='$link2'>$arrayTwoEl...</a>"; #Добавляем ссылку на последние два слова

    $b2 = $arrayLast.$lastTwoElWithLink; #Объединение всего предложения с последними двумя словами ссылкой
    echo $b2;
*/


// $array = [1, 5, 3, 5, 6, 7, 8, 9, 25, 24, 18, 26, 27, 2, 29, 30, 31, 1, 2, 4, 2, 3, 4, 1, 2, 5, 3, 8, 4, 3, 9, 27, 21, 15, 14, 19, 44, 18, 22, 10, 1, 4, 43, 91, 9, 6, 9
// , 66, 44, 76, 54, 84, 46, 61, 34, 57, 81, 49, 51, 34, 65, 75, 35, 39, 89, 91, 96, 34, 51, 20, 41, 31, 111, 22, 41, 223, 221, 44, 58, 91, 90, 43, 133, 411, 433, 612, 334, 31, 32, 57, 52, 79,
// 70, 60, 40, 41, 57, 51, 44, 99];

// $b = [];
// sort($array);

// foreach($array as $v)
// {
//     $b[$v][]=$v;

// }


// foreach($b as $k => $v){

//     if (count($v) > 1) {
//         $x[] = $k;
//     }


// }

//     print_r($x);





// $arrDuals = array_count_values($array);

//     for ($i=1; $i < count($arrDuals); $i++) {

//   echo $i;

// }
//  print_r($x);
//     echo "<hr>";
//     print_r($arrDuals);
    // for ($i = 101; $i > $arrDuals; $i--) {

    //     if ($arrDuals) {
    //         // code...
    //     }


    // }















        // foreach($array as $ar) {

        // }




// $a=array(1,2,4,2,3,4,1,2,5,3,8,4,3,9);
// $b=array();
// sort($a);

// foreach($a as $k=>$v)
// {
//     $b[$v][]=$v;

// }

// echo 'Найдено: <br>';
// foreach($b as $k => $v){
//     echo 'значение-&nbsp'.$k.'&nbsp встречается &nbsp'.count($v).'&nbsp раз(раза) <br>';
// }

//             for ($i = count($arr);$i < count($arr);$i++) {

//                      //$arrEl = $arr[$i];

//                if ($this.$arr == $arr[$i]) {

//                     echo $arrEl;
//                     echo $arr[$i];

//                   $dual[] = $arr[$i];

//                }
//                else {
//                     $arrEl++;
//                }

// }

               //$dual[] = $arr[$i];




       // function sortArray ($arr) {

       //     if (count($arr) < 2) return $arr;

       //     $unique = [];
       //     $dual = [];
       //     for ($i = count($arr);$i < count($arr);$i++) {

       //      $arrEl = $arr[$i];

       //         if ($arr[$i] == $arrEl) {

       //            $dual[] = $arr[$i];

       //         }
       //         else {
       //              $arrEl++;
       //         }
       //         $dual[] = $arr[$i];


       //     }

       //         return array_merge($unique, array($arr[0]), $dual);



       // }

       //        print_r(sortArray($array));




 // $size = GetImageSize ("image.jpg"); #получаем размеры картинки
 // $source = ImageCreateFromJPEG ("image.jpg"); #источник картинки

 // $width = $size[0];
 // $height = $size[1];

 // $new_height = 100;
 // $new_width = 200;

 // $new_data = ImageCreateTrueColor ($new_width, $new_height); #создаем новое изображения со своими размерами

 // ImageCopyResampled ($new_data, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

 // ImageJPEG ($new_data, "new_photo.jpg", 100);
 // imagedestroy($source); #удаление источника, чтобы не перегружать память


 //     echo "<img src='new_photo.jpg'>";



 // $size = GetImageSize ("image.jpg");

 // $source = ImageCreateFromJPEG ("image.jpg");

 // $width = $size[0];
 // $height = $size[1];

 // $koef = $width/200; #коэфф., который равен изначальной ширине, деленной на желаеммую ширину

 // $new_height = $height/$koef; #новая высота

 // $new_data = ImageCreateTrueColor (200, $new_height);

 // ImageCopyResampled ($new_data, $source, 0, 0, 0, 0, 200, $new_height, $width, $height);

 // ImageJPEG ($new_data, "new_photo2.jpg", 100);
 // imagedestroy($source);

 //     echo "<img src='new_photo2.jpg'>";


    // $link1 = 'https://ru.wikipedia.org/wiki/Европейский_удильщик';
    // $c1 = mb_substr($a, 0, 180);
    // $d1 = mb_substr($a, 180, 16).'...';
    // $b1 = $c1."<a href='$link1'>$d1</a>";
    // echo $b1;

    // echo "<br />";

    // $link2 = 'https://ru.wikipedia.org/wiki/Европейский_удильщик';
    // $a2 = mb_substr($a, 0, 180);

    // $array = explode(' ', $a2);
    // $countArr = count($array);

    // function lastTwoElements($array){
    //     for($i = count($array);$i > count($array)-3;$i--) { #Выбираем два последних элемента из массива
    //     $el1[] = ' '.$array[$i];

    // }
    //     return array_reverse($el1);
    // }

    // function allElements($array){
    //      array_pop($array);array_pop($array); #Получаем массив без двух последних элементов
    //      return $array;
    // }


    // $arrayLast = implode(' ', allElements($array));
    // $arrayTwoEl = implode(' ', lastTwoElements($array));

    // $lastTwoElWithLink = "<a href='$link2'>$arrayTwoEl...</a>"; #Добавляем ссылку на последние два слова

    // $taskComplete = $arrayLast.$lastTwoElWithLink; #Объединение всего предложения с последними двумя словами ссылкой
    // echo $taskComplete;







//$array1 = array_pop($array);
// echo end($array);

    // while($countArr != $countArr[]-2) {
    //     $countArr[]--;

    // }

        // function F1($array)
        // {
        //   // $arrayBefore = count($array)-1;
        //   // array_pop($array);
        //   // $predlastEl = $array[$arrayBefore];
        //   // print_r($array);
        //   // return $predlastEl;

        //     array_pop($array);
        //         $predlastEl = $array[$arrayBefore];
        //          print_r($array);
        //             return $predlastEl;


        // }
        // F1($array);













//
//$password = 'MegaUeban123';
//
//
//    $hash = password_hash($password, PASSWORD_DEFAULT);
//    $verify = password_verify($password, $hash);
//    var_dump($verify);
//
// $array = [1,5,3,5,6,7,8,9,25,24,18,26,27,2,29,30,31];
//
//
//
//        function sortArray ($arr) {
//
//            if (count($arr) <2 ) return $arr;
//
//            $greater = [];
//            $less = [];
//            for ($i = 1;$i < count($arr);$i++) {
//
//                if ($arr[$i] < $arr[0]) {
//                    $less[] = $arr[$i];
//                }
//                $greater[] = $arr[$i];
//
//
//            }
//
//                return array_merge($less, array($arr[0]), $greater);
//
//
//
//        }
//
//            //    print_r(sortArray($array));



//
//function sortArray ($arr) {
//
//
//
//    if (count($arr) < 2) return $arr;
//
//    $less = [];
//    $ful = [];
//
//    for ($i = 1;$i < count($arr);$i++) {
//
//        if ($arr[$i] < $arr[0]) {
//            $less[] = $arr[$i];
//        }
//        else {
//            $ful[] = $arr[$i];
//        }
//
//
//
//
//
//    }
//    return array_merge(sortArray($less), array($arr[0]), sortArray($ful));
//
//}
//
//print_r(sortArray($array));







//echo "<pre>";
//$res = file_get_contents('xulstore.json');
//
//$data = json_decode($res);
//var_dump($data);
//echo "</pre>";
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);
//
//    file_put_contents('name.json');

//require_once "controllers/MainController.php";
//require_once "controllers/ItemsController.php";
//require_once "controllers/UsersController.php";



//    $arr = [1, 5, 7, -1];
//
//    foreach ($arr as $el) {
//
//        if ($el = 12);
//
//    }



//
//     function testSort1($array)
//    {
//        // Условие окончания рекурсии
//        if (!$lenght = count($array)) return $array; //Если $lenght уже не существует
//
//        // Обнуляем
//        $x = $y = [];
//
//        // Те, что меньше первого элемента в одну сторону, те что больше в другую.
//        // А что-бы цикл не ушел в бесконечность начинаем его с $i = 1
//        for ($i = 1; $i < $lenght; $i++) {
//            if ($array[$i] > $array[0]) $x[] = $array[$i];
//            else $y[] = $array[$i];
//        }
//
//
//        return array_merge(testSort1($y), array($array[0]), testSort1($x));
//    }

//$array = [1,5,3,5,6,7,8,9,25,24,18,26,27,2,29,30,31];
//        print_r(testSort1($array)) ;
//
//    function testSort ($arr) {
//
//        if (!$lenght = count($arr)) return $arr;
//
//
//        $x = $y = [];
//
//
//        for ($i = 1;$i < $lenght;$i++) {
//
//            if ($arr[$i] > $arr[0]) $x[] = $arr[$i];
//            else $y[] = $arr[$i];
//
//        }
//
//        return array_merge(testSort($y), array($arr[0]), testSort($x));
//
//
//    }
//
//print_r(testSort($array)) ;



//        foreach ($arr as $key => $value) {
//
//            if ()
//
//        }













//$x = 12;
//
//$y = 0;
//        function  java ($x, $y) {
//
//            $z = $x / $y;
//
//            return $z;
//
//        }
//
//            try {
//                if ($x != 0 && $y != 0) {
//                    echo java($x, $y);
//                }
//
//                throw new Exception('x или y равно нулю');
//            }
//            catch (Exception $e) {
//               echo $e->getMessage();
//
//            }
//
































//
//    $mysql = new PDO("mysql:host=just; dbname=db", "mysql", "mysql");
//
//    $query = "SELECT * FROM `users` WHERE `id`= ':id' AND `login` = ':login'";
//    $stmt = $mysql->prepare($query);
//    $num  = 1;
//    $name = 'Nikita';
//    $stmt->bindParam(':id', $num, PDO::PARAM_INT);
//    $stmt->bindParam(':login', $name, PDO::PARAM_STR, 16);
//    $stmt->execute();
//    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
//    print_r($res);
//
//$result = mysqli_query($mysql, $query);
//





























//    class Register {
//        private static $data = [];
//        public static function set ($key, $value) {
//            self::$data[$key] = $value;
//
//        }
//        public static function get ($key) {
//            return array_key_exists($key, self::$data) ? self::$data[$key] : null;
//        }
//    }
//
//        class lang {
//
//            private static $text = [
//                    'ru' => "Добро пожаловать!",
//                    'en' => "Welcome!"
//            ];
//                public static function getText ($uid, $lang = 'ru') {
//                    return self::$text[$lang][$uid];
//                }
//        }
//
//    function getHTML () {
//        $html  = "
//            <html>
//            <head><title>".Register::get('title')."</title></head>
//<body bgcolor='".Register::get('bgcolor')."'>
//
//</body>
//</html>
//        ";
//        return $html;
//    }
//
//    function getUserConfig () {
//        getTitle ();
//        getBackGround ();
//    }
//
//    function getTitle () {
//        Register::set('title', "Title_".rand(1, 100));
//    }
//    function getBackGround () {
//        $colors = ['grey', 'black', 'brown', 'aqua', 'orange', 'red'];
//        $color = $colors[rand(0, 5)];
//        Register::set('bgcolor', $color);
//    }

//    echo getUserConfig();
//    echo  getHTML();









































//trait Dild {
//        public $name = 'Heck';
//        protected $suckemDick = 'Yes';
//        private $Nigger = 'Ni';
//
//
//}
//class Dildo {
//    public $name = 'Heck';
//    protected $suckemDick = 'Yes';
//    private $Nigger = 'Ni';
//
//}
//
//    class B  {
//        use Dild;
//        public function math () {
//            $this->
//        }
//        public static  function getData () {
//          //  header("Content-type: applications/json");
//            $arr = [
//                    'hello'=>'world',
//                    'num'=>123
//            ];
//            print_r($arr);
//          //  die(json_encode($arr));
//        }
//    }
//
//
//
//
//B::getData();
//
//















// $m->UpdateLogin(Dicker);
//$l->SetLogin(Privet, 123);

//       print_r($l);
//       echo "<br />";
//        $l->SetLogin('Dick');
//        $l->SetPass('qwerty');
//    print_r($l);
//
//

































//    class Parents{
//
//
//       public function name ()
//        {
//                return 'Hello, anydick';
//        }
//
//
//    }
//        class Child extends Parents {
//
//
//                public  function test($childExtends  = 'Nikita')
//                {
//
//                   if ($childExtends = 'Nikita') {
//                       $name = $childExtends;
//                       return 'Hello, '.$name;
//
//                   } else {
//                       return parent::name();
//                   }
//                }
//
//        }
//
//    $nm = new Child();
//
//   echo $nm->test('Nikita');



































//    class A {
//
//
//        public function sayHello () {
//            return 'Hello from '.__METHOD__;
//        }
//
//    }
//    class B extends A {
//
//        public function sayHello ($old = false) {
//
//            if ($old) {
//                echo parent::sayHello();
//            }
//            else {
//                return 'Hello from '.__METHOD__;
//            }
//
//
//    }
//
//    }
//class C extends B {
//
//    public function test ($old = false) {
//
//        return $this->sayHello($old);
//
//    }
//
//}
//
//        $c = new C();
//
//    echo $c->test();
//    echo '<br />';
//    echo $c->test(true);
//
//




//    $arr = [];
//    const ARR_LEN = 100;
//        for ($i = 0;$i < ARR_LEN;$i++) {
//            $arr[] = "SOME VALUE " . rand(1, 100);
//
//        }
//
//
//    $html =
//"<p>Ключ</p>
// <p>Значение</p>"
//    ;
//        foreach ($arr as $key=>$value){
//            $html .= "<p>".$key."</p>
//        <p>".$value."</p>";
//
//        }
//
//
//
//    print_r($arr);
//
//$vis =isset($_COOKIE['visits']) ? $_COOKIE['visits']: 0;
//
//    setcookie(cock, ++$vis);
//
//echo $vis;


//$mysql = new mysqli('just', 'mysql','mysql', 'data2');
//
//$query = ("SELECT `login`, `name` FROM `users`");
//
//$arr = array();
//
//while ($row = $arr->fetch_assoc()) {
//    echo "<pre>";
//    print_r($row);
//    echo "</pre>";
//}
//
//$result = $mysql->query($query);
//
//var_dump($child);
//



/*while ($row = $res->fetch_assoc()) {
    echo "<pre>";
    print_r($row);
    echo "</pre>";
}*/

?>

<!--<form action="index.php" method="post" style="display: flex; flex-direction: column; max-width: 20%">
    <input type="hidden" name="action" value="change">
    <input type="text" name="name">-->
<!--   <input type="password" name="pass">-->

   <!-- <input type="submit" value='Отправить'>

</form>-->
<?php



//$login = $_REQUEST['name'];
//$pass = $_REQUEST['pass'];
//
//    $arr = [
//            'admin'=>123
//    ];
//
//        if (isset($_REQUEST['name']) && $_REQUEST['name'] == $arr['admin']) {
//            setcookie(cock, $cock);
//            echo 'Yes';
//        }else {echo "Вы не указали не те данные";}
//
//
//?>

<?php
//if($_COOKIE['user'] == '') :
//?>
<!--<a href="signup.php">Регистрация</a>-->
<!--<a href="login.php">Авторизация</a>-->
<!---->
<?php //else:?>
<!--    <p>Привет, --><?//=$_COOKIE['user']?><!--. Чтобы выйти нажмите <a href="/exit.php">здесь</a>.</p>-->
<!--    <form action="comments.php" method="post">-->
<!---->
<!--        <textarea name="comm" id="" cols="30" rows="10"></textarea>-->
<!--    <input type="submit">-->
<!--    </form>-->
<!--    <p>--><?//=$_COOKIE['user']?><!--:--><?php
//
//
//
//        ?><!--</p>-->
<!---->
<!---->
<?php //endif;?>
<!---->

















<script src="script.js"></script>
</body>
</html>
<?php
//$html = '<table border="1">';
//    $html .= '<thead><th> № </th>';
//    for ($i =1;$i <= 9;$i++) {
//    $html .= '<th>'.$i.'</th>';
//    }
//
//
//    $html .= '</thead><tbody>';
//    for ($i = 1;$i <= 9; $i++) {
//    $html .= '<tr><td>'.$i.'</td>';
//        for ($j = 1;$j <= 9; $j++) {
//            $html .= '<td>' . $i * $j . '</td>';
//        }
//        $html .= '</tr>';
//    }
//    $html .= "</body></table>";
//
//    echo $html;