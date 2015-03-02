<?php

namespace App\Controllers;

use \Phoenix\Core\Controller;
use \Phoenix\Core\Model;
use \Phoenix\Http\Request;

/**
 * Index controller.
 *
 * @version 1.9
 * @author MPI
 *        
 */
class IndexController extends Controller {

    /**
     * Index controller constructor.
     *
     * @param Phoenix\Core\Model $model            
     * @param Phoenix\Http\Request $request            
     * @return void
     */
    public function __construct(Model $model, Request $request) {
        parent::__construct($model, $request);
    }

    /**
     * Show index page.
     *
     * @access HTML
     * @return void
     */
    public function index() {
    }
}
?>