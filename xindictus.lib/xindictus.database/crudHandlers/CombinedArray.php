<?php
/**
 * Created by PhpStorm.
 * User: Kotsos
 * Date: 12/12/2015
 * Time: 05:21
 */

/**
 * Class CombinedArray: Used for the creation of the associative array
 * which is the foundation array for the insert query.
 */
abstract class CombinedArray{

    protected function construct_insert_values(){
        /**
         * Assign table fields of the class in a temp variable.
         */
        $temp_table_fields = static::$table_fields;

        /**
         * Shift temp to remove first element which is always the table id.
         * Table id is auto increment, so there is no need for it in insertion.
         */
        if($temp_table_fields[0] == NULL) {
            array_shift($temp_table_fields);
        }

        /**
         * Creating the array with the values of the class.
         */
        $field_values = array();
        foreach($temp_table_fields as $table_field){
            array_push($field_values, $this->$table_field);
        }

        /**
         * We combine the 2 arrays to create an associative one.
         */
        $combined_array = array_combine($temp_table_fields, $field_values);

        /**
         * We unset the temporary array that we assigned.
         */
        unset($temp_table_fields);

        /**
         * We return the combined array.
         */
        return $combined_array;
    }

    protected function construct_update_values(array $update_fields){
        /**
         * Search the update fields given through a whitelist.
         * $table_fields act as our whitelist.
         */
        //$temp_table_fields = static::$table_fields;

        /**
         * Creating the array with the values of the class.
         */
        $field_values = array();
        foreach($update_fields as $table_field){
            array_push($field_values, $this->$table_field);
        }

        /**
         * We combine the 2 arrays to create an associative one.
         */
        $combined_array = array_combine($update_fields, $field_values);

        /**
         * We return the combined array.
         */
        return (array)$combined_array;
    }
}