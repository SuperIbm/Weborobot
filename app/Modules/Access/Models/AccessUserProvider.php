<?php
/**
 * Модуль Авторизации и аунтификации.
 * Этот модуль содержит все классы для работы с авторизацией и аунтификацией.
 * @package App.Modules.Access
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\Access\Models;

use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Path;
use App\Modules\User\Repositories\User as UserRepository;
use App\Modules\User\Repositories\BlockIp as BlockIpRepository;

/**
 * Класс драйвер для проверки аунтификации.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessUserProvider implements UserProvider
{
/**
 * Репозитарий пользователей.
 * @var \App\Modules\User\Repositories\User
 * @version 1.0
 * @since 1.0
 */
private $_User;

/**
 * Репозитарий заблокированных IP адресов.
 * @var \App\Modules\User\Repositories\BlockIp
 * @version 1.0
 * @since 1.0
 */
private $_BlockIp;


	/**
	 * Конструктор.
	 * @param \App\Modules\User\Repositories\User $User Репозитарий для таблицы пользователей.
	 * @param \App\Modules\User\Repositories\BlockIp $BlockIp Репозитарий для таблицы блокированных IP.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function __construct(UserRepository $User, BlockIpRepository $BlockIp)
	{
	$this->_User = $User;
	$this->_BlockIp = $BlockIp;
	}

	/**
	 * Возвращение пользователя по его уникальному индификатору
	 * @param mixed $identifier ID пользователя.
	 * @return \Illuminate\Contracts\Auth\Authenticatable|Object|null
	 * @version 1.0
 	 * @since 1.0
	 */
	public function retrieveById($identifier)
	{
	$user = $this->_User->get($identifier);

	    if($user) return $this->_User->newInstance($user, true);
	    else return null;
	}

	/**
	 * Возвращение пользователя через уникальный индификатор и токен помнить меня.
	 * @param mixed $identifier ID пользователя.
	 * @param string $token Токен.
	 * @return \Illuminate\Contracts\Auth\Authenticatable|Object|null
	 * @version 1.0
 	 * @since 1.0
	 */
	public function retrieveByToken($identifier, $token)
	{
		$user = $this->_User->read
		(
			[
				[
				'property' => $this->_User->getAuthIdentifierName(),
				'value' => $identifier
				],
				[
				'property' => $this->_User->getRememberTokenName(),
				'value' => $token
				]
			],
			true
		);

		if($user) return $this->_User->newInstance($user[0], true);
		else return null;
	}

	/**
	 * Обновление токена "запомнить меня" через указание пользователя.
	 * @param \Illuminate\Contracts\Auth\Authenticatable $User
	 * @param string $token Токен.
	 * @return void
	 * @version 1.0
 	 * @since 1.0
	 */
	public function updateRememberToken(UserContract $User, $token)
	{
	$User->setRememberToken($token);
	$User->save();
	}


	/**
	 * Возвращение пользователя по заданным параметрам.
	 * @param array $credentials Параметры.
	 * @return \Illuminate\Contracts\Auth\Authenticatable|Object|null
	 * @version 1.0
 	 * @since 1.0
	 */
	public function retrieveByCredentials(array $credentials)
	{
		if(empty($credentials)) return null;

	$where = [];

		foreach($credentials as $key => $value)
		{
			if(!Str::contains($key, 'password'))
			{
				$where[] =
				[
				'property' => $key,
				'value' => $value
				];
			}
		}

	$user = $this->_User->read($where);

		if($user) return $this->_User->newInstance($user[0], true);
		else return null;
	}


	/**
	 * Сравнение пользователя по заданным параметрам.
	 * @param \Illuminate\Contracts\Auth\Authenticatable $User
	 * @param array  $credentials
	 * @return bool Вернет true если есть совпадение.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function validateCredentials(UserContract $User, array $credentials)
	{
	$blockIps = $this->_BlockIp->read([], true);

		if($blockIps)
		{
			for($i = 0; $i < count($blockIps); $i++)
			{
			$pattern = str_replace("*", "[0-9]{1,3}", $blockIps[$i]["ip"]);
			$pattern = "/^".$pattern."$/";

				if(preg_match($pattern, Path::getUserIp(), $matches)) return false;
			}
		}

	return $credentials['password'] == $User->getAuthPassword();
	}
}
