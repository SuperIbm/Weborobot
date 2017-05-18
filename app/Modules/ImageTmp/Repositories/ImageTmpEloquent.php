<?php
/**
 * Модуль Временных изображений.
 * Этот модуль содержит все классы для работы с временными изображениями.
 * @package App.Modules.ImageTmp
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\ImageTmp\Repositories;

use Carbon\Carbon;
use DB;
use Cache;
use Image;
use ImageFilter;
use App\Models\RepositaryEloquent;

/**
 * Класс репозитария временных изображений на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ImageTmpEloquent extends ImageTmp
{
use RepositaryEloquent;

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
	public function create($path, $width = null, $height = null, $tags = null, $filters = null)
	{
	    if(is_array($tags))
        {
        asort($tags);
        $tags = implode(', ', $tags);
        }

        if($width || $height) $pathThumbnail = Image::cut($path, $width, $height);
        else $pathThumbnail = $path;

        if($filters)
        {
            foreach($filters as $k => $v)
            {
            $path = ImageFilter::driver($k)->filter($path, $v);
            }
        }

        return $this->_create(['ImageTmp'],
            [
            'idImageSource' => $path,
            'idImageThumbnail' => $pathThumbnail,
            'dateAdd' => Carbon::now(),
            'tags' => $tags
            ]
        );
	}

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
	public function update($id, $path, $width = null, $height = null, $tags = null, $filters = null)
	{
        if(is_array($tags))
        {
        asort($tags);
        $tags = implode(', ', $tags);
        }

        if($width || $height) $pathThumbnail = Image::cut($path, $width, $height);
        else $pathThumbnail = $path;

        if($filters)
        {
            foreach($filters as $k => $v)
            {
            $path = ImageFilter::driver($k)->filter($path, $v);
            }
        }

        return $this->_update(['ImageTmp'], $id,
            [
            'idImageSource' => $path,
            'idImageThumbnail' => $pathThumbnail,
            'dateAdd' => Carbon::now(),
            'tags' => $tags
            ]
        );
	}

    /**
     * Получение записи по ее ID.
     * @param int $id ID записи.
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
	public function get($id)
	{
	$image = $this->_getById($id);

		if($image) return $image;
		else
		{
			$data = Cache::tags(['ImageTmp', 'ImageTmpItem'])->remember($id, $this->getCacheMinutes(),
				function() use ($id)
				{
				$Model = $this->getModel()->find($id);

					if($Model)
					{
					$data = $Model->toArray();
					$this->_setById($id, $data);

					return $data;
					}
					else return null;
				}
			);

			if($data) return $data;
			else return null;
		}
	}

    /**
     * Получение всех записей.
     * @param array|string $tags Фильтрация по тэгам.
     * @param int $seconds Количество секунд жизни изображения (в выборку войдут все записи, которые существуют больше заданнаого времени).
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
	public function find($tags = null, $seconds = null)
	{
    $filters = null;

        if($tags)
        {
            if(is_string($tags)) $tags = [$tags];

        asort($tags);
        $tagsString = "";

            for($i = 0; $i < count($tags); $i++)
            {
                if($tagsString != "") $tagsString .= ", ";
            }

            $filters[] =
            [
            'property' => 'tags',
            'operator' => '=',
            'value' => $tagsString
            ];
        }

        if($seconds)
        {
            $filters[] =
            [
            'property' => DB::raw('ADDDATE(dateAdd, INTERVAL '.$seconds.' SECOND)'),
            'operator' => '>=',
            'value' => date("Y-m-d H:i:s")
            ];
        }

    return $this->_read(['ImageTmp', 'ImageTmpItem'], false, $filters);
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
	$Model = $this->newInstance();
	$status = $Model->destroy($id);

		if(!$status) $this->addError($Model->getErrors());
		else Cache::tags(['ImageTmp', 'ImageItemTmp'])->forget($id);

	return $status;
	}
}