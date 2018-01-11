<?php
error_reporting(E_ALL);

interface DatabaseConnectionInterface
{

    /**
     * Подключение к СУБД
     *
     * @param string $host         Адрес хоста
     * @param string $login        Логин
     * @param string $password     Пароль
     * @param string $databaseName Имя базы данных
     *
     * @return void
     */
    public function connect($host, $login, $password, $databaseName);

    /**
     * Получение объекта подключения к СУБД
     *
     * @returns \PDO
     * @throws \RuntimeException При отсутствии подключения к БД
     */
    public function getConnection();

}

class PDOMysql implements DatabaseConnectionInterface{

    private static $instance;

    public function connect($host, $login, $password, $databaseName)
    {
        if(self::$instance == null){
            self::$instance = new PDO("mysql:host=$host;dbname=$databaseName", $login, $password);
        }
        return self::$instance;
    }

    public function getConnection()
    {
        try {
            return self::$instance;
        } catch (RuntimeException $e) {
            echo 'Подключение не удалось: ' . $e->getMessage();
        }
    }
}

$r = new PDOMysql;
$r->connect("db", "php-junior", "php-junior", "php-junior");//db
$stmt = $r->getConnection();

/*$arr = $stmt->query('SELECT
	goods.id as goods_id, goods.title as goods_title, goods.page as goods_page_id, goods.sortorder as goods_sortorder,
	pages.id as pages_id, pages.title as pages_title, pages.sortorder as pages_sortorder
FROM pages LEFT JOIN goods
ON pages.id=goods.page WHERE pages.active = 1');
var_dump($arr->fetchAll());*/

$main = [];

$pages = $stmt->query('SELECT * FROM pages WHERE pages.active = 1 ORDER BY pages.sortorder ASC');

while ($pages_all = $pages->fetch())
{
    $p_id = (int)$pages_all['id'];
    $main[$p_id] = $pages_all;
    $goods = $stmt->query("SELECT * FROM goods WHERE page IN ($p_id) ORDER BY goods.sortorder ASC");
    if($goods) $main[$p_id]['goods'] = $goods->fetchAll();
}

foreach ($main as $arr_page){
    echo "<span>" . $arr_page['title'] . "</span><br />";
    if(count($arr_page['goods']) > 0){
        foreach ($arr_page['goods'] as $arr_goods){
            echo "<span style='padding: 20px'>" . $arr_goods['title'] . "</span><br />";
        }
    }
}


?>
    <div style="padding: 20px"></div>
<?php

class MinMaxNumber {

    protected $min;
    protected $max;
    protected $string = "";

    public function __construct($min, $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    public function rangeNumber()
    {
        foreach (range($this->min, $this->max) as $number) {
            $this->string .= $this->validateNumber($number);
        }

        return $this->lineBreak($this->string);
    }

    protected function validateNumber($number)
    {
        if($number % 2 === 0){
            return $number . ' ';
        }
    }

    protected function lineBreak($string){
        $this->string = substr($string, 0, -1);
        return $this->string . "\\" . "n";
    }
}

$num = new MinMaxNumber(10,80);
echo $num->rangeNumber();
