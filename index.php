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

