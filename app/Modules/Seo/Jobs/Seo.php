<?php
/**
 * Модуль Статистики сайта.
 * Этот модуль содержит все классы для работы со татистикой сайта.
 * @package App.Modules.Seo
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\Seo\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Seo as SeoFacade;
use Carbon\Carbon;


/**
 * Класс очереди для записи статистики сайта.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Seo implements ShouldQueue
{
use InteractsWithQueue, Queueable, SerializesModels;

/**
 * Статус нужно ли добавить просмотр.
 * @var bool
 * @since 1.0
 * @version 1.0
 */
private $_addShows;

/**
 * Статус нужно ли добавить визит.
 * @var bool
 * @since 1.0
 * @version 1.0
 */
private $_addVisitis;

/**
 * Статус нужно ли добавить посетителя.
 * @var bool
 * @since 1.0
 * @version 1.0
 */
private $_addVisitors;

/**
 * Статус нужно ли добавить нового посетителя.
 * @var bool
 * @since 1.0
 * @version 1.0
 */
private $_addVisitorsNew;

    
    /**
     * Конструктор.
     * @param bool $addShows Добавить просмотр.
     * @param bool $addVisitis Добавить визиты.
     * @param bool $addVisitors Добавить посетителя.
     * @param bool $addVisitorsNew Добавить нового посетителя.
     * @version 1.0
     * @since 1.0
     */
    public function __construct($addShows, $addVisitis, $addVisitors, $addVisitorsNew)
    {
        $this->_addShows = $addShows;
        $this->_addVisitis = $addVisitis;
        $this->_addVisitors = $addVisitors;
        $this->_addVisitorsNew = $addVisitorsNew;
    }

    /**
     * Выполнение задания.
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function handle()
    {
        $records = SeoFacade::read
        (
            [
                [
                'property' => 'dateStat',
                'value' => Carbon::now()->minute(0)->hour(0)->second(0)
                ]
            ]
        );

    $found = true;

        if(!$records)
        {
            $record =
            [
            'dateStat' => Carbon::now()->format('Y-m-d'),
            'visits' => 0,
            'shows' => 0,
            'visitors' => 0,
            'visitorsNew' => 0
            ];

        $found = false;
        }
        else $record = $records[0];

        if($this->_addShows == true) $record["shows"]++;
        if($this->_addVisitis == true) $record["visits"]++;
        if($this->_addVisitors == true) $record["visitors"]++;
        if($this->_addVisitorsNew == true) $record["visitorsNew"]++;

        if($found == false) SeoFacade::create($record);
        else SeoFacade::update($record["idSeo"], $record);
    }
}