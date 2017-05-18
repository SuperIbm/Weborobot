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

use Illuminate\Routing\Controller;

use App\Modules\Filesystem\Http\Requests\FilesystemDirAdminReadRequest;
use App\Modules\Filesystem\Http\Requests\FilesystemDirAdminDestroyRequest;
use App\Modules\Filesystem\Http\Requests\FilesystemDirAdminCreateRequest;
use App\Modules\Filesystem\Http\Requests\FilesystemDirAdminUpdateRequest;
use App\Modules\Filesystem\Http\Requests\FilesystemDirAdminMoveRequest;

/**
 * Класс контроллер для работы с директориями в административной системе.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class FilesystemDirAdminController extends Controller
{
    /**
     * Чтение данных.
     * @param \App\Modules\Filesystem\Http\Requests\FilesystemDirAdminReadRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function read(FilesystemDirAdminReadRequest $Request)
    {
    $data = [];
    $directories = Storage::disk('root')->directories($Request->input('node', '.'));

        if($directories)
        {
            for($i = 0; $i < count($directories); $i++)
            {
            $data[] = $this->_getDirectory($directories[$i]);
            }
        }

    return response()->json($data);
    }

    /**
     * Получение данных директории.
     * @param string $path Путь к дирректории.
     * @return array Массив данных директории.
     * @since 1.0
     * @version 1.0
     */
    private function _getDirectory($path)
    {
    $sep = Path::getFizDirSepDefault();
    $name = basename($path);
    $pathFull = Storage::disk('root')->getDriver()->getAdapter()->applyPathPrefix($path);
    $pathFull = $pathFull.$sep;
    $dirname = dirname($path) == "." ? null : dirname($path);
    $path = $dirname.$name.$sep;

        return
        [
        'name' => $name,
        'path' => $path,
        'pathFull' => $pathFull,
        'expanded' => false,
        'leaf' => false,
        'icon' => 'app/Modules/Admin/Admin/images/icon_folder.png'
        ];
    }


    /**
     * Добавление данных.
     * @param \App\Modules\Filesystem\Http\Requests\FilesystemDirAdminCreateRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function create(FilesystemDirAdminCreateRequest $Request)
    {
    Storage::disk('root')->makeDirectory($Request->input('name'));

        Log::info('Добавление папки в файловой системе.',
            [
            'module' => "Filesystem",
            'login' => Auth::getUser()->login,
            'type' => 'create'
            ]
        );

        $data =
        [
        'success' => true,
        'data' => $this->_getDirectory($Request->input('name'))
        ];

    return response()->json($data);
    }


    /**
     * Обновление данных.
     * @param \App\Modules\Filesystem\Http\Requests\FilesystemDirAdminUpdateRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function update(FilesystemDirAdminUpdateRequest $Request)
    {
    $path = dirname($Request->input('path')).'/'.$Request->input('name');

        if(!Storage::disk('root')->has($path)) Storage::disk('root')->move($Request->input('path'), $path);

        Log::info('Изменение папки в файловой системе.',
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
     * @param \App\Modules\Filesystem\Http\Requests\FilesystemDirAdminDestroyRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function destroy(FilesystemDirAdminDestroyRequest $Request)
    {
    Storage::disk('root')->deleteDirectory($Request->input('path'));

        Log::info('Удаление папки в файловой системе.',
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


    /**
     * Перенос файла.
     * @param \App\Modules\Filesystem\Http\Requests\FilesystemDirAdminMoveRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function move(FilesystemDirAdminMoveRequest $Request)
    {
    Storage::disk('root')->move($Request->input('pathFrom'), $Request->input('pathTarget').basename($Request->input('pathFrom')));

        Log::info('Перенос файлов файловой системе.',
            [
            'module' => "Filesystem",
            'login' => Auth::getUser()->login,
            'type' => 'update'
            ]
        );

        $data =
        [
        'success' => true
        ];

    return response()->json($data);
    }
}
