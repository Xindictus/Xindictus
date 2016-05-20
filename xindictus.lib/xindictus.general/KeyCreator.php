<?php
/**
 * Created by PhpStorm.
 * User: Kotsos
 * Date: 18/12/2015
 * Time: 06:53
 */

interface KeyCreator
{
    function createNumKey($user_id);
    function createStringKey();
    function createMixedKey();

}