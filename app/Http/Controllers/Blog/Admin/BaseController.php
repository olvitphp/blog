<?php

namespace App\Http\Controllers\Blog\Admin;
namespace App\Http\Controllers\Blog\Admin;


use App\Http\Controllers\Blog\BaseController as GuestBaseController;

/**
 * Базовый контролер для всех контролеров управления
 * блогом в панели администрирования.
 *
 * Должен дыть родителем всех контролеров управления блогом.
 * @package App\Http\Controllers\Blog\Admin
 *
 */


abstract class BaseController extends GuestBaseController
{
    /**
     * BaseController constructor.
     */

    public function __construct()
    {

    }

}
