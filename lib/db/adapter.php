<?php
/**
 * Абстрактный класс адаптера БД
 */

namespace PhpBase\Db;


/**
 * Абстрактный класс адаптера БД
 */
abstract class Adapter
{
    /**
     * @var \PDO
     */
    private $_pdo;

    /**
     * @var string
     */
    protected $_dsn;

    /**
     * @var string
     */
    protected $_user;

    /**
     * @var string
     */
    protected $_password;


    /**
     * Конструктор класса
     *
     * @param string $dsn Строка для соединения
     * @param string $user Имя пользователя
     * @param string $password Пароль
     */
    public function __construct($dsn, $user, $password)
    {
        $this->_dsn = $dsn;
        $this->_user = $user;
        $this->_password = $password;
    }


    /**
     * Создает и возвращает объект PDO
     *
     * @return \PDO
     */
    protected function _getPdo()
    {
        if ($this->_pdo === null) {
            $this->_pdo =
                new \PDO($this->_dsn, $this->_user, $this->_password);
        }

        return $this->_pdo;
    }


    /**
     * Выполняет произвольный запрос с параметрами
     *
     * @param string $sql Запрос
     * @param array $params Массив параметров
     * @return \PDOStatement
     */
    public function query($sql, array $params = [])
    {
        $st = $this->_getPdo()->prepare($sql);
        $st->execute($params);
        return $st;
    }


    /**
     * Экранирует переменную
     *
     * @param mixed $val Переменная
     * @return string
     */
    public function quote($val)
    {
        return $this->_getPdo()->quote($val);
    }


    /**
     * Выбирает записи
     *
     * @param string $table Таблица
     * @param array $where Массив условий
     * @param array $order Массив сортировки
     * @param int $limit Ограничение
     * @param int $offset Сдвиг
     * @return \PDOStatement
     */
    abstract  public function select(
        $table, array $where = [], $order = [], $limit = 0, $offset = 0);


    /**
     * Добавляет запись
     *
     * @param string $table Таблица
     * @param array $values Массив значений
     * @return \PDOStatement
     */
    abstract public function insert($table, array $values);


    /**
     * Обновляет записи
     *
     * @param string $table Таблица
     * @param array $where Массив условий
     * @param array $set Массив новых значений
     * @param array $order Массив сортировки
     * @param int $limit Ограничение
     * @return \PDOStatement
     */
    abstract public function update(
        $table, array $where, array $set, array $order = [], $limit = 0);


    /**
     * Удаляет записи
     *
     * @param string $table Таблица
     * @param array $where Массив условий
     * @param array $order Массив сортировки
     * @param int $limit Ограничение
     * @return \PDOStatement
     */
    abstract  function delete(
        $table, array $where, array $order = [], $limit = 0);
}

