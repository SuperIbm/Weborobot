<?php
/**
 * Модуль Файловая система.
 * Этот модуль содержит все классы для работы с файловой системой.
 * @package App.Modules.Filesystem
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Filesystem\Http\Controllers;

use Log;
use Auth;
use Path;
use Storage;
use Util;

use Illuminate\Routing\Controller;
use Carbon\Carbon;
use File;

use App\Modules\Filesystem\Http\Requests\FilesystemFileAdminReadRequest;
use App\Modules\Filesystem\Http\Requests\FilesystemFileAdminCreateRequest;
use App\Modules\Filesystem\Http\Requests\FilesystemFileAdminUpdateRequest;
use App\Modules\Filesystem\Http\Requests\FilesystemFileAdminDestroyRequest;


/**
 * Класс контроллер для работы с файлами в административной системе.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class FilesystemFileAdminController extends Controller
{
    /**
     * Чтение данных.
     * @param \App\Modules\Filesystem\Http\Requests\FilesystemFileAdminReadRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function read(FilesystemFileAdminReadRequest $Request)
    {
    $data = [];
    $directories = Storage::disk('root')->directories($Request->input('path', '.'));
    $files = Storage::disk('root')->files($Request->input('path', '.'));
    $directories = array_merge($directories, $files);

        if($directories)
        {
        $sep = Path::getFizDirSepDefault();

            for($i = 0; $i < count($directories); $i++)
            {
            $name = basename($directories[$i]);
            $pathFull = Storage::disk('root')->getDriver()->getAdapter()->applyPathPrefix($directories[$i]);
            $type = filetype($pathFull);
            $pathFull = $type == 'dir' ? $pathFull.$sep : $pathFull;
            $path = $type == 'dir' ? $Request->input('path').$name.$sep : $Request->input('path').$name;
            $filestat = stat($pathFull);

                $data[] =
                [
                'name' => pathinfo($name, PATHINFO_FILENAME),
                'nameFull' => $name,
                'path' => $path,
                'pathFull' => $pathFull,
                'type' => filetype($pathFull),
                'size' => $type == 'dir' ? 0 : $filestat['size'],
                'dateAccess' => Carbon::createFromTimestamp(fileatime($pathFull))->format('d.m.Y H:i:s'),
                'dateModify' => Carbon::createFromTimestamp(filemtime($pathFull))->format('d.m.Y H:i:s'),
                'dateCreate' => Carbon::createFromTimestamp(filectime($pathFull))->format('d.m.Y H:i:s'),
                'extension' => Util::toLower(pathinfo($name, PATHINFO_EXTENSION)),
                'mode' => $this->_getModeByPath($pathFull),
                'uid' => $filestat['uid'],
                'gid' => $filestat['gid'],
                'content' => $this->_getContent($path)
                ];
            }
        }

        $data =
        [
        "data" => $data,
        "total" => count($data),
        "success" => true
        ];

    return response()->json($data);
    }


    /**
     * Получение доступа к файлу по его пути.
     * @param string $path Путь к файлу.
     * @return string Возвращает режим доступа.
     * @since 1.0
     */
    private function _getModeByPath($path)
    {
        if(file_exists($path))
        {
        $perms = fileperms($path);

            if(($perms & 0xC000) == 0xC000) $info = 's';
            elseif(($perms & 0xA000) == 0xA000) $info = 'l';
            elseif (($perms & 0x8000) == 0x8000) $info = '-';
            elseif(($perms & 0x6000) == 0x6000) $info = 'b';
            elseif(($perms & 0x4000) == 0x4000) $info = 'd';
            elseif(($perms & 0x2000) == 0x2000) $info = 'c';
            elseif(($perms & 0x1000) == 0x1000) $info = 'p';
            else $info = 'u';

            // Владелец
            $info .= (($perms & 0x0100) ? 'r' : '-');
            $info .= (($perms & 0x0080) ? 'w' : '-');
            $info .= (($perms & 0x0040) ?
                (($perms & 0x0800) ? 's' : 'x' ) :
                (($perms & 0x0800) ? 'S' : '-'));

            // Группа
            $info .= (($perms & 0x0020) ? 'r' : '-');
            $info .= (($perms & 0x0010) ? 'w' : '-');
            $info .= (($perms & 0x0008) ?
                (($perms & 0x0400) ? 's' : 'x' ) :
                (($perms & 0x0400) ? 'S' : '-'));

            // Мир
            $info .= (($perms & 0x0004) ? 'r' : '-');
            $info .= (($perms & 0x0002) ? 'w' : '-');
            $info .= (($perms & 0x0001) ?
                (($perms & 0x0200) ? 't' : 'x' ) :
                (($perms & 0x0200) ? 'T' : '-'));

        return $info;
        }
        else return null;
    }


    /**
     * Получение контента файла.
     * @param string $path Путь к файлу.
     * @return string Возвращает контент файла.
     * @since 1.0
     */
    private function _getContent($path)
    {
    $extension = Util::toLower(pathinfo($path, PATHINFO_EXTENSION));

        if
        (
            $extension == "php" ||
            $extension == "txt" ||
            $extension == "tpl" ||
            $extension == "htm" ||
            $extension == "html" ||
            $extension == "js" ||
            $extension == "css" ||
            $extension == "tmp" ||
            $extension == "htaccess" ||
            $extension == "htc" ||
            $extension == "xml" ||
            $extension == "sql" ||
            $extension == "htaccess"
        ) return Storage::disk('root')->get($path);
        else return null;
    }


    /**
     * Добавление данных.
     * @param \App\Modules\Filesystem\Http\Requests\FilesystemFileAdminCreateRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function create(FilesystemFileAdminCreateRequest $Request)
    {
        if($Request->input('nameFull')) $path = $Request->input('path').$Request->input('nameFull');
        else $path = $Request->input('path').$Request->file('file')->getClientOriginalName();

    Storage::disk('root')->put($path, File::get($Request->file('file')));

        Log::info('Добавление файла в файловой системе.',
            [
            'module' => "Filesystem",
            'login' => Auth::getUser()->login,
            'type' => 'create'
            ]
        );

        $data =
        [
        'success' => true
        ];

    return response()->json($data);
    }


    /**
     * Обновление данных.
     * @param \App\Modules\Filesystem\Http\Requests\FilesystemFileAdminUpdateRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function update(FilesystemFileAdminUpdateRequest $Request)
    {
    $path = dirname($Request->input('path')).'/'.$Request->input('nameFull');

        if(!Storage::disk('root')->has($path)) Storage::disk('root')->move($Request->input('path'), $path);

    Storage::disk('root')->put($path, $Request->input('content'));

        Log::info('Изменение файла в файловой системе.',
            [
            'module' => "Filesystem",
            'login' => Auth::getUser()->login,
            'type' => 'update'
            ]
        );

        $data =
        [
        'success' => true,
            'data' =>
            [
            'path' => $path
            ]
        ];

    return response()->json($data);
    }


    /**
     * Удаление данных.
     * @param \App\Modules\Filesystem\Http\Requests\FilesystemFileAdminDestroyRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function destroy(FilesystemFileAdminDestroyRequest $Request)
    {
    Storage::disk('root')->delete($Request->input('path'));

        Log::info('Удаление файла в файловой системе.',
            [
            'module' => "Filesystem",
            'login' => Auth::getUser()->login,
            'type' => 'destroy'
            ]
        );

        $data =
        [
        'success' => true
        ];

    return response()->json($data);
    }
}
