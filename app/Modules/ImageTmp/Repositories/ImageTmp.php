<?php
/**
 * Модуль Временных изображений.
 * Этот модуль содержит все классы для работы с временными изображениями.
 * @package App.Modules.ImageTmp
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\ImageTmp\Repositories;

use File;
use Util;
use App\Models\Repositary;

/**
 * Абстрактный класс построения репозитария.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class ImageTmp extends Repositary
{
/**
 * Полученные раннее изображения.
 * Будем хранить данные полученных ранее изображений, чтобы снизить нагрузку на систему.
 * @var array
 * @version 1.0
 * @since 1.0
 */
private static $_images = Array();

	/**
	 * Получение изображения по ее ID из базы ранее полученных изображений.
	 * @param int $id ID изображения.
	 * @return array|bool Массив данных страницы.
	 * @since 1.0
	 * @version 1.0
	 */
	protected static function _getById($id)
	{
		if(isset(self::$_images[$id])) return self::$_images[$id];
		else return false;
	}


	/**
	 * Установка данных изображения по ее ID в базу ранее полученных изображений.
	 * @param int $id ID изображения.
	 * @param array $image Данные изображения.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	protected static function _setById($id, $image)
	{
	self::$_images[$id] = $image;
	}


	/**
	 * Получение всех записей.
     * @param array|string $tags Фильтрация по тэгам.
     * @param int $seconds Количество секунд жизни изображения (в выборку войдут все записи, которые существуют больше заданнаого времени).
	 * @return array Массив данных.
	 * @since 1.0
	 * @version 1.0
	 */
	abstract public function find($tags = null, $seconds = null);


    /**
     * Получение записи по ее ID.
     * @param int $id ID записи.
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
	abstract public function get($id);


	/**
	 * Создание.
	 * @param string $path Путь к файлу.
     * @param int $width Ширина превью.
     * @param int $height Высота превью.
     * @param array|string $tags Тэги изображения.
     * @param array $filters Набор фильтров для превью.
     * <pre>
     * [
     *     'fixedSize' =>
     *     [
     *     'width' => 200,
     *     'height' => 300
     *     ],
     *     'watermark' =>
     *     [
     *     'path' => 'someimage.png',
     *     'left' => 15,
     *     'bottom' => 15
     *     ]
     * ]
     * </pre>
	 * @return int Вернет ID последней вставленной строки. Если ошибка, то вернет false.
	 * @since 1.0
	 * @version 1.0
	 */
	abstract public function create($path, $width = null, $height = null, $tags = null, $filters = null);


	/**
	 * Обновление.
	 * @param int $id Id записи для обновления.
	 * @param string $path Путь к файлу.
     * @param int $width Ширина превью.
     * @param int $height Высота превью.
     * @param array|string $tags Тэги изображения.
     * @param array $filters Набор фильтров для превью.
     * <pre>
     * [
     *     'fixedSize' =>
     *     [
     *     'width' => 200,
     *     'height' => 300
     *     ],
     *     'watermark' =>
     *     [
     *     'path' => 'someimage.png',
     *     'left' => 15,
     *     'bottom' => 15
     *     ]
     * ]
     * </pre>
	 * @return int Вернет ID вставленной строки. Если ошибка, то вернет false.
	 * @since 1.0
	 * @version 1.0
	 */
	abstract public function update($id, $path, $width = null, $height = null, $tags = null, $filters = null);


	/**
	 * Удаление.
	 * @param int|array $id Id записи для удаления.
	 * @return bool Вернет булево значение успешности операции.
	 * @since 1.0
	 * @version 1.0
	 */
	abstract public function destroy($id);
}