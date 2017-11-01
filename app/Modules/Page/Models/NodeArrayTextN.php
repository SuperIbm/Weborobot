<?php
/**
 * Модуль Страницы сайта.
 * Этот модуль содержит все классы для работы со страницами сайта.
 * @package App.Modules.Page
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Page\Models;

use App;
use Auth;
use Util;
use App\Models\Tree\Arr\NodeArray;


/**
 * Класс для проектирования узла древовидной структуры в виде массива с переводом каретки к тэгу &lt;br /&gt; и удаление HTML разметки.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class NodeArrayTextN extends NodeArray
{
/**
 * Массив доступных страниц для редактирования администратору.
 * @var array
 * @since 1.0
 * @version 1.0
 */
private $_pagesUpdate = Array();

/**
 * Ссылка на директорию компонента ядра панели администативной системы.
 * @var string
 * @since 1.0
 * @version 1.0
 */
private $_dir = 'app/Modules/Admin/admin/images/';

    /**
     * Конструктор.
     * @since 1.0
     * @version 1.0
     */
    public function __construct()
    {
    $User = App::make('\App\Modules\User\Repositories\User');
    $access = $User->gates(Auth::getUser()['idUser']);
    $this->_pagesUpdate = $access['pagesUpdate'];
    }

	/**
	 * Метод рендеринга узла древовидной структуры.
	 * @param int $id ID узла.
	 * @param string $value Значение узла.
	 * @param bool $currentBranch Находиться ли этот узел на текущей ветке.
	 * @param bool $currentNode Является ли этот узел текущим.
	 * @param array $data Все данные этого узла.
	 * @return array Возвращает массив данных узла древовидной структуры. Где индексы должны строится так:
	 * <ul>
	 * 	<li>NodeArray::getNameId() - Получение индекса ID узла</li>
	 * 	<li>NodeArray::getNameValue() - Получение индекса значения узла</li>
	 * 	<li>NodeArray::getNameCurrentNode() - Получение индекса, что хранит статус, является ли это узел текущим.</li>
	 * 	<li>NodeArray::getNameCurrentBranch() - Получение индекса, что хранит статус, находится ли этот узел на текущей ветке.</li>
	 * </ul>
	 * Допустимо включать и другие индексы, помимо тех, которые указаны здесь как обязательные.
	 * @since 1.0
	 * @version 1.0
	 * @see \App\Models\Tree\Node::_renderer
	 */
	protected function _renderer($id, $value, $currentBranch, $currentNode, $data)
	{
        if($this->getParent()) $dataParent = $this->getParent()->getResults();
        else $dataParent = Array();

        if($data['idPageReferen'] == 0)
        {
        $icon = $this->_dir.'icon_home.png';

            if(count($this->_pagesUpdate))
            {
                if(in_array($data['idPage'], $this->_pagesUpdate) == true) $data['isMeetsEdit'] = 1;
                else $data['isMeetsEdit'] = 0;
            }
            else $data['isMeetsEdit'] = 1;
        }
        else
        {
            if($data['modeAccess'] == 'Наследовать')
            {
            $data['modeAccessReal'] = $data['modeAccess'];
            $data['modeAccess'] = @$dataParent['modeAccess'];
            }
            else $data['modeAccessReal'] = $data['modeAccess'];

            if(count($this->_pagesUpdate))
            {
                if(in_array($data['idPage'], $this->_pagesUpdate) == true)
                {
                $data['isMeetsEdit'] = 1;
                $data['isMeetsEditExtend'] = 1;
                }
                else if(isset($dataParent['isMeetsEdit']) && @$data['isMeetsEditExtend'])
                {
                $data['isMeetsEdit'] = $dataParent['isMeetsEdit'];
                $data['isMeetsEditExtend'] = 1;
                }
                else $data['isMeetsEdit'] = 0;
            }
            else $data['isMeetsEdit'] = 1;

            if($data['isMeetsEdit'] === 0) $icon = $this->_dir.'icon_page_edit.png';
            else if($data['status'] == 'Не активен') $icon = $this->_dir.'icon_page_status.png';
            else if($data['modeAccess'] == 'Ограниченный') $icon = $this->_dir.'icon_page_mode.png';
            else if($data['showInMenu'] == 'Не показывать') $icon = $this->_dir.'icon_page_noShow.png';
            else if($data['showInMenu'] == 'Только в карте сайта') $icon = $this->_dir.'icon_page_showInMap.png';
            else $icon = $this->_dir.'icon_page.png';
        }

        if($data['nameLink'] && isset($dataParent['path'])) $path = $dataParent['path'].$data['nameLink'].'/';
        else if($data['nameLink']) $path = $data['nameLink'].'/';
        else $path = '';

        $node = array
		(
		self::getNameId() => $id,
		self::getNameValue() => Util::getTextN($value),
		self::getNameCurrentNode() => $currentNode,
		self::getNameCurrentBranch() => $currentBranch,
        'expanded' => true,
        'leaf' => false,
        'icon' => $icon,
        'path' => $path
		);

        if($this->getParams('isCheckedAccess') == true)
        {
            if(($data['modeAccess'] == 'Наследовать' && isset($dataParent['isChecked'])) || $data['modeAccess'] == 'Ограниченный')
            {
                if(@$data['id_userGroupPage']) $node['isChecked'] = true;
                else $node['isChecked'] = false;

            $node['expanded'] = true;
            }
        }

    return array_merge($node, $data);
	}
}
?>