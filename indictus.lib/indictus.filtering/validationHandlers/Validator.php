<?php
/**
 * Created by PhpStorm.
 * User: Kotsos
 * Date: 17/12/2015
 * Time: 09:08
 */
namespace Indictus\Filtering\Validation;

interface Validator{

    function strip_input(&$input);
    function validate_input();

}