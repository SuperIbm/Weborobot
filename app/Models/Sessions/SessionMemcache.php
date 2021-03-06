<?php
/**
 * Сессии.
 * Этот пакет содержит драйвера для разных хранилищь сессий.
 * @package App.Models.Session
 * @since 1.0
 * @version 1.0
 */
namespace App\Models\Sessions;

use SessionHandlerInterface;
use \Memcache;


/**
 * Класс драйвер сессии на основе Memcache.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SessionMemcache implements SessionHandlerInterface
{
/**
 * Объект кеширования на основе Memcache.
 * @var \Memcache
 * @version 1.0
 * @since 1.0
 */
private $_Memcache;

/**
 * Название индекса, который хранит сессии.
 * @var string
 * @version 1.0
 * @since 1.0
 */
private $_indexSessions = "sessions";


	/**
	 * Конструктор.
	 * @since 1.0
	 * @version 1.0
	 */
	public function __construct()
	{
	$this->_setCache(new Memcache());
	$this->getCache()->connect(config("session.memcache.host"), config("session.memcache.port"));
	}

	/**
	 * Метод открытия системы сессий.
	 * @param string $savePath Путь записи.
	 * @param string $sessionName Название сессии.
	 * @return bool Возвращает удачность открытия сессии.
	 * @since 1.0
	 * @version 1.0
	 */
	public function open($savePath, $sessionName)
	{
	return true;
	}

	/**
	 * Метод закрытия системы сессий.
	 * @return bool Возвращает удачность открытия сессии.
	 * @since 1.0
	 * @version 1.0
	 */
	public function close()
	{
	return true;
	}


	/**
	 * Считывыне сессии.
	 * @param string $sessionId ID сессии.
	 * @return mixed Вернет значение сессии.
	 * @since 1.0
	 * @version 1.0
	 */
	public function read($sessionId)
	{
	$index = config("session.connection.memcache.project")."_".$this->_indexSessions;
	$data = $this->getCache()->get($index);

		if($data)
		{
			if(isset($data[$sessionId])) return $data[$sessionId];
			else return null;
		}
		return null;
	}


	/**
	 * Запись сессии.
	 * @param string $sessionId ID сессии.
	 * @param mixed $data Данные на запись.
	 * @return bool Удачность записи.
	 * @since 1.0
	 * @version 1.0
	 */
	public function write($sessionId, $data)
	{
	$index = config("session.connection.memcache.project")."_".$this->_indexSessions;
	$result = $this->getCache()->get($index);

		if(isset($result)) $result[$sessionId] = $data;
		else
		{
			$result =
			[
				[
				$sessionId => $data
				]
			];
		}

	$compress = config("session.connection.memcache.compress") ? MEMCACHE_COMPRESSED : 0;
	return $this->getCache()->set($index, $result, $compress, config("session.lifetime") * 60);
	}


	/**
	 * Уничтожение сессии.
	 * @param string $sessionId ID сессии.
	 * @return bool Удачность удаления.
	 * @since 1.0
	 * @version 1.0
	 */
	public function destroy($sessionId)
	{
	$index = config("session.connection.memcache.project")."_".$this->_indexSessions;
	$data = $this->getCache()->get($index);

		if(isset($data))
		{
			if(isset($data[$sessionId]))
			{
			unset($data[$sessionId]);
			$compress = config("session.connection.memcache.compress") ? MEMCACHE_COMPRESSED : 0;
			$this->getCache()->set($index, $data, $compress, config("session.lifetime") * 60);
			}
		}

	return true;
	}

	/**
	 * Конвертация времени жизни сессии.
	 * @param string $lifetime Время жизни.
	 * @return bool Возвращенное значение конвертации.
	 * @since 1.0
	 * @version 1.0
	 */
	public function gc($lifetime)
	{
	return true;
	}


	/**
	 * Получение объекта кеширования на основе Memcache.
	 * @return \Memcache Объект кеширования.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getCache()
	{
	return $this->_Memcache;
	}

	/**
	 * Получение объекта кеширования на основе Memcache.
	 * @param \Memcache $Memcache Объект кеширования на основе Memcache.
	 * @return $this
	 * @since 1.0
	 * @version 1.0
	 */
	private function _setCache(Memcache $Memcache)
	{
	$this->_Memcache = $Memcache;
	return $this;
	}
}
?>