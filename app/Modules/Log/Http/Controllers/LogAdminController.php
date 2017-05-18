<?php
/**
 * Модуль Логирование.
 * Этот модуль содержит все классы для работы с логированием.
 * @package App.Modules.Log
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Log\Http\Controllers;

use LogReader;
use Illuminate\Routing\Controller;
use Util;

use App\Modules\Log\Http\Requests\LogAdminReadRequest;


/**
 * Класс контроллер для работы с логами в административной системе.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class LogAdminController extends Controller
{
    /**
     * Чтение данных.
     * @param \App\Modules\Log\Http\Requests\LogAdminReadRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
    */
    public function read(LogAdminReadRequest $Request)
    {
    $sorts = json_decode($Request->input('sort'), true);
    $filters = json_decode($Request->input('filter'), true);
    $LogReader = LogReader::getFacadeRoot();

        if($sorts) $LogReader->orderBy($sorts[0]['property'], Util::toLower($sorts[0]['direction']));

        if($filters)
        {
            for($i = 0; $i < count($filters); $i++)
            {
                if($filters[$i]['property'] == 'level') $LogReader->level($filters[$i]['value']);
                else if($filters[$i]['property'] == 'environment') $LogReader->environment($filters[$i]['value'][0]);
            }
        }

        if($Request->input('limit')) $record = $LogReader->paginate($Request->input('limit'))->toArray();
        else
        {
        $record = $LogReader->get()->toArray();
        $record['data'] = $record;
        $record['total'] = count($record);
        }

    $data = [];
    $i = 0;

        foreach($record['data'] as $k => $v)
        {
        $level = $record['data'][$k]->level;

            switch($record['data'][$k]->level)
            {
            case 'info': $level = 'Сообщение'; break;
            case 'alert': $level = 'Внимание'; break;
            case 'critical': $level = 'Критично'; break;
            case 'debug': $level = 'Отладка'; break;
            case 'error': $level = 'Ошибка'; break;
            case 'notice': $level = 'Уведомление'; break;
            case 'warning': $level = 'Предупреждение'; break;
            }

        $environment = $record['data'][$k]->environment;

            switch($record['data'][$k]->environment)
            {
            case 'local': $environment = 'Локальное'; break;
            case 'production': $environment = 'Рабочее'; break;
            }

            $data[$i] =
            [
            'id' => $record['data'][$k]->id,
            'date' => $record['data'][$k]->date->format('d.m.Y H:i:s'),
            'level' => $level,
            'environment' => $environment,
            'header' => $record['data'][$k]->header,
            'stack' => $record['data'][$k]->stack,
            'context' => $record['data'][$k]->getAttribute('context')
            ];

        $i++;
        }

        $data =
        [
        "data" => $data == null ? [] : $data,
        "total" => $record['total'],
        "success" => true
        ];

    return response()->json($data);
    }
}
