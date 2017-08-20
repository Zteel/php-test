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
class PDOConnect implements DatabaseConnectionInterface{
    protected $PDO;
    public function connect($host, $login, $password, $databaseName){
        try {
            if($this->PDO = new PDO("mysql:host=$host;dbname=$databaseName", $login, $password)){}
            else{
                throw new RuntimeException("Problems with connection");
            };
        } catch (RuntimeException $e) {
            echo "problems with connection params";
            //die;
        }
    }
    public function getConnection(){
        if($this->PDO instanceof PDO){
            return $this->PDO;
        }
    }

}

class DbTemplates{
    public static function getProducts($stmp){
        $category="";
        while(($row = $stmp->fetch(PDO::FETCH_ASSOC)) !== false) {
            if($category!==$row['title']){
                $category=$row['title'];
                echo $row['title']."<br>";
            }
            echo "-".$row['g_title']."<br>";
        }
    }
}
class EvenNumbers{
    public static function getLine($min, $max){
        if($max==$min || $max!==$min){
            for($i=$min;$i<=$max;$i++){
                if($i!==0){
                    echo ($i % 2) ? "" :"$i\n";
                }
            }
        }
        else{
            echo "Выберите подходящий диапазон";
        }
    }

}
$db=new PDOConnect();
$db->connect('localhost','php-junior','php-junior','php-junior');
$stmp=$db->getConnection()->prepare("SELECT pages.title, goods.title as g_title FROM pages JOIN goods ON pages.id=goods.page WHERE pages.active<>0 ORDER BY pages.sortorder,goods.sortorder");
$stmp->execute();
DbTemplates::getProducts($stmp);
if($_POST['min'] && $_POST['max'] || $_POST['min']==0 || $_POST['max']==0){
    EvenNumbers::getLine($_POST['min'],$_POST['max']);
}
else{
    echo "Выберите диапазон";
}
?>
<form method="post">
    <label for="min">Минимум диапазона</label><input type="number" name="min">
    <label for="max">Максимум диапазона</label><input type="number" name="max">
    <button type="submit">Смотреть результат</button>
</form>
