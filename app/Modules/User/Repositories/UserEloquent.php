<?php
/**
 * Модуль Пользователи.
 * Этот модуль содержит все классы для работы с пользователями, авторизации и аунтификации в системе.
 * @package App.Modules.User
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\User\Repositories;

use App;
use Session;
use App\Models\RepositaryEloquent;

/**
 * Класс репозитария пользователей на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserEloquent extends User
{
use RepositaryEloquent;

    /**
     * Получить по первичному ключу.
     * @param int $id Первичный ключ.
     * @param bool $active Булево значение, если определить как true, то будет получать только активные записи.
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
    public function get($id, $active = null)
    {
    return $this->_get(['User', 'UserItem'], $id, $active);
    }


    /**
     * Чтение данных.
     * @param array $filters Фильтрация данных.
     * @param bool $active Булево значение, если определить как true, то будет получать только активные записи.
     * @param array $sorts Массив значений для сортировки.
     * @param int $offset Отступ вывода.
     * @param int $limit Лимит вывода.
     * @param array $with Массив связанных моделей.
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
    public function read($filters = null, $active = null, $sorts = null, $offset = null, $limit = null, $with = null)
    {
    return $this->_read(['User', 'UserItem'], false, $filters, $active, $sorts, $offset, $limit, $with);
    }

    /**
     * Подсчет общего количества записей.
     * @param array $filters Фильтрация данных.
     * @param bool $active Булево значение, если определить как true, то будет получать только активные записи.
     * @param array $with Массив связанных моделей.
     * @return int Количество.
     * @since 1.0
     * @version 1.0
     */
    public function count($filters = null, $active = null, $with = null)
    {
    return $this->_read(['User', 'UserItem'], true, $filters, $active, null, null, null, $with);
    }

    /**
     * Создание.
     * @param array $data Данные для добавления.
     * @return int Вернет ID последней вставленной строки. Если ошибка, то вернет false.
     * @since 1.0
     * @version 1.0
     */
    public function create(array $data)
    {
    return $this->_create(['UserItem'], $data);
    }

    /**
     * Обновление.
     * @param int $id Id записи для обновления.
     * @param array $data Данные для обновления.
     * @return int Вернет ID вставленной строки. Если ошибка, то вернет false.
     * @since 1.0
     * @version 1.0
     */
    public function update($id, array $data)
    {
    return $this->_update(['UserItem'], $id, $data);
    }

    /**
     * Удаление.
     * @param int|array $id Id записи для удаления.
     * @return bool Вернет булево значение успешности операции.
     * @since 1.0
     * @version 1.0
     */
    public function destroy($id)
    {
    return $this->_destroy(['UserItem'], $id);
    }


	/**
	 * Получение всех доступов к разделам.
	 * @param int $id Уникальный индетификатор пользователя.
	 * @return array Вернет массив всех доступов к разделам.
	 * @version 1.0
	 * @since 1.0
	 */
	public function gates($id)
	{
		if(!Session::has('user'))
		{
            $userGroupOfUsers = App::make('App\Modules\User\Repositories\UserGroupOfUser')
            ->read
            (
                [
                    [
                    'property' => 'idUser',
                    'value' => $id
                    ]
                ]
            );

            $data =
            [
            'sections' => [],
            'pages' => [],
            'pagesUpdate' => [],
            'roles' => [],
            'groups' => []
            ];

            for($i = 0; $i < count($userGroupOfUsers); $i++)
            {
                $userGroups = App::make('App\Modules\User\Repositories\UserGroup')
                ->read
                (
                    [
                        [
                        'property' => 'idUserGroup',
                        'value' => $userGroupOfUsers[$i]['idUserGroup']
                        ]
                    ],
                    true
                );

                if($userGroups)
                {
                $data['groups'] = array_merge($data['groups'], $userGroups);

                    for($y = 0; $y < count($userGroups); $y++)
                    {
                        $userGroupRoles = App::make('App\Modules\User\Repositories\UserGroupRole')
                        ->read
                        (
                            [
                                [
                                'property' => 'idUserGroup',
                                'value' => $userGroups[$y]['idUserGroup']
                                ]
                            ]
                        );

                        if($userGroupRoles)
                        {
                            for($z = 0; $z < count($userGroupRoles); $z++)
                            {
                                $roles = App::make('App\Modules\User\Repositories\UserRole')
                                ->read
                                (
                                    [
                                        [
                                        'property' => 'idUserRole',
                                        'value' => $userGroupRoles[$z]['idUserRole']
                                        ]
                                    ]
                                );

                                if($roles) $data['roles'] = array_merge($data['roles'], $roles);

                                $userRolePages = App::make('App\Modules\User\Repositories\UserRolePage')
                                ->read
                                (
                                    [
                                        [
                                        'property' => 'idUserRole',
                                        'value' => $userGroupRoles[$z]['idUserRole']
                                        ]
                                    ]
                                );

                                if($userRolePages)
                                {
                                    for($u = 0; $u < count($userRolePages); $u++)
                                    {
                                    $data['pagesUpdate'][] = App::make('App\Modules\Page\Repositories\Page')->get($userRolePages[$u]['idPage'], true);
                                    }
                                }

                                $userRoleAdminSections = App::make('App\Modules\User\Repositories\UserRoleAdminSection')
                                ->read
                                (
                                    [
                                        [
                                        'property' => 'idUserRole',
                                        'value' => $userGroupRoles[$z]['idUserRole']
                                        ]
                                    ]
                                );

                                if($userRoleAdminSections)
                                {
                                    for($u = 0; $u < count($userRoleAdminSections); $u++)
                                    {
                                    $adminSection = App::make('App\Modules\AdminSection\Repositories\AdminSection')->get($userRoleAdminSections[$u]['idAdminSection'], true);

                                        if($adminSection)
                                        {
                                        $module = App::make('App\Modules\Module\Repositories\Module')->get($adminSection['idModule'], true);

                                            if($module)
                                            {
                                                if(!isset($data['sections'][$module['nameModule']]))
                                                {
                                                    $data['sections'][$module['nameModule']] =
                                                    [
                                                    'isRead' => $userRoleAdminSections[$u]['isRead'],
                                                    'isUpdate' => $userRoleAdminSections[$u]['isUpdate'],
                                                    'isCreate' => $userRoleAdminSections[$u]['isCreate'],
                                                    'isDestroy' => $userRoleAdminSections[$u]['isDestroy']
                                                    ];
                                                }
                                                else
                                                {
                                                    if($userRoleAdminSections[$u]['isRead'])
                                                        $data['sections'][$module['nameModule']]['isRead'] = 1;

                                                    if($userRoleAdminSections[$u]['isRead'])
                                                        $data['sections'][$module['nameModule']]['isUpdate'] = 1;

                                                    if($userRoleAdminSections[$u]['isRead'])
                                                        $data['sections'][$module['nameModule']]['isCreate'] = 1;

                                                    if($userRoleAdminSections[$u]['isRead'])
                                                        $data['sections'][$module['nameModule']]['isDestroy'] = 1;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        $userGroupPages = App::make('App\Modules\User\Repositories\UserGroupPage')
                        ->read
                        (
                            [
                                [
                                'property' => 'idUserGroup',
                                'value' => $userGroups[$y]['idUserGroup']
                                ]
                            ]
                        );

                        if($userGroupPages) $data['pages'] = array_merge($data['pages'], $userGroupPages);
                    }
                }
            }

        Session::set('user', $data);
        return $data;
        }

    return Session::get('user');
	}



	/**
	 * Получение название уникального токена для пользователя.
	 * @return string Вернет название токена.
	 * @version 1.0
	 * @since 1.0
	 */
	public function getRememberTokenName()
	{
	return $this->newInstance()->getRememberTokenName();
	}


	/**
	 * Получение название уникального идентификатора для пользователя.
	 * @return string Вернет название идентификатора.
	 * @version 1.0
	 * @since 1.0
	 */
	public function getAuthIdentifierName()
	{
	return $this->newInstance()->getAuthIdentifierName();
	}
}