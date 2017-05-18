<?php
/**
 * Модуль Ядро системы.
 * Этот модуль содержит все классы для работы с ядром системы.
 * @package App.Modules.Core
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;


/**
 * Класс контроллер для ядра.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class CoreController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $Request)
    {
    return view('core::test');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {

    return view('core::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $Request
     * @return Response
     */
    public function store(Request $Request)
    {
    echo $Request->get("name");
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
    return view('core::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $Request
     * @return Response
     */
    public function update(Request $Request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
