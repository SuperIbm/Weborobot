<?php
/**
 * Модуль Настройки сайта.
 * Этот модуль содержит все классы для работы с настройками сайта.
 * @package App.Modules.Setting
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\Setting\Http\Controllers;

use Log;
use Auth;

use Illuminate\Routing\Controller;
use Dotenv\Loader;
use Storage;

use App\Modules\Setting\Http\Requests\SettingAdminUpdateRequest;


/**
 * Класс контроллер для работы с настройками сайта в административной части.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SettingAdminController extends Controller
{
    /**
     * Чтение данных.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function read()
    {
    $path = Storage::disk('root')->getDriver()->getAdapter()->applyPathPrefix('/.env');

        $data =
        [
        "data" => [$this->_read($path)],
        "total" => 1,
        "success" => true
        ];

    return response()->json($data);
    }


    /**
     * Чтение с файла.
     * @param string $path Путь к файлу.
     * @param bool $comment Требуется ли получить закоментированные значения.
     * @return array Массив значений.
     * @since 1.0
     * @version 1.0
     */
    private function _read($path, $comment = false)
    {
    $Loader = new Loader($path);
    $lines = $Loader->load();
    $data = [];

        for($i = 0; $i < count($lines); $i++)
        {
            $record = $Loader->processFilters($lines[$i], "4");

            if($record)
            {
                if(strpos(ltrim($record[0]), '#') !== 0 || $comment == true) $data[$record[0]] = trim($record[1]);
            }
        }

    return $data;
    }


    /**
     * Обновление данных.
     * @param \App\Modules\Setting\Http\Requests\SettingAdminUpdateRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function update(SettingAdminUpdateRequest $Request)
    {
    $path = Storage::disk('root')->getDriver()->getAdapter()->applyPathPrefix('/.env');
    $data = $this->_read($path, true);

        if(isset($data[$Request->input('label')])) $data[$Request->input('label')] = $Request->input('value');

    Storage::disk('root')->put('/.env', '');

        foreach($data as $k => $v)
        {
        Storage::disk('root')->append('/.env', $k.'='.$v);
        }

        Log::info('Обновление настроек.',
            [
            'module' => "Setting",
            'login' => Auth::getUser()->login,
            'type' => 'update'
            ]
        );

        return response()->json
        (
            [
            'success' => true
            ]
        );
    }
}
