<?php
/**
 * Created by PhpStorm.
 * User: Kotsos
 * Date: 9/12/2015
 * Time: 20:09
 */

/**
 * Include the CombinedArray Abstract Class that provides the function
 * that creates the associative array of table fields and their values.
 */
include_once(__DIR__ . "/CombinedArray.php");

/**
 * Include the error handler class.
 */
include_once(__DIR__ . "/../../xindictus.exception/error_handlers/LogErrorHandler.php");

class lulz extends CombinedArray{

    private $table_fields;
    private $named_parameters;
    private $field_values = array();

    /**
     * @param array $combined_array: Is an associative array constructed
     * like this: (table fields => value)
     */
    private function insert_arrays(array $combined_array){

        /**
         * Re-initialize class' private members.
         */
        $this->table_fields = "";
        $this->named_parameters = "";
        unset($this->field_values);
        $this->field_values = array();

        foreach($combined_array as $key => &$value){

            /**
             * Creating an array of fields for the insert query.
             */
            $this->table_fields .= "$key,";

            /**
             * Dynamically creating an array of named parameters
             * to be used for the prepared statement of the "insert".
             */
            $this->named_parameters .= ":$key,";

            /**
             * Dynamically creating the array that will
             * host the bindings for the query
             */
            $this->field_values[":".$key] = $value;
        }
        /**
         * Unset foreach's variables
         */
        unset($key);
        unset($value);

        $this->table_fields = rtrim($this->table_fields, ",");
        $this->named_parameters = rtrim($this->named_parameters, ",");
//        echo $this->table_fields."<br>";
//        echo $this->named_parameters."<br>";
//        print_r($this->field_values);
//        echo '<br>';
    }

    private function update_arrays(array $combined_array){
        $update_string = "";

        unset($this->field_values);
        $this->field_values = array();

        foreach($combined_array as $key => &$value){

            /**
             * Creating the update string.
             */
            $update_string .= "$key=:$key,";

            /**
             * Dynamically creating the array that will
             * host the bindings for the query
             */
            $this->field_values[":".$key] = $value;
        }
        /**
         * Unset foreach's variables
         */
        unset($key);
        unset($value);

        $update_string = rtrim($update_string, ",");
        return (string)$update_string;
    }

    /**
     * @param CustomPDO $connection: The function takes the connection to the database to execute the query.
     * @param $table_name: The table name the query will use.
     * @param array $combined_array: The associative array with the table fields and their values.
     * @return int
     */
    protected function process_insert(CustomPDO $connection, $table_name, array $combined_array){

        /**
         * Initialize arrays for the insert.
         */
        $this->insert_arrays($combined_array);

        try {

            /**
             * Dynamically creating the query.
             */
            $insert_query = "INSERT INTO $table_name($this->table_fields) VALUES($this->named_parameters)";

            /**
             * Prepared Statement and execution.
             */
            $insert_stmt = $connection->prepare($insert_query);
            $insert_stmt->execute($this->field_values);

            /**
             * Further check if insertion happened.
             */
            $affected_rows = $insert_stmt->rowCount();
            if($affected_rows == 0){
                throw new PDOException("AFFECTED ROWS = 0");
            }
        } catch(PDOException $insert_exception){
            $error_string = 'Insert Fail :: '.$insert_query.PHP_EOL.
                'Table Fields given :: ('. $this->table_fields . ')' . PHP_EOL .
                'Named parameters :: ('. $this->named_parameters . ')' . PHP_EOL.
                'Values given :: ('. implode(",", $this->field_values) . ')' . PHP_EOL.
                'Database Message :: '.$insert_exception->getMessage();
            $category = "INSERT_QUERIES";

            $err_handler = new LogErrorHandler($error_string, $category);
            $err_handler->createLogs();
//            include __DIR__."/../../../index.php";
//            exit;
            return 1;
        }
        return 0;
    }

    protected function process_select(CustomPDO $connection, $table_name, array $table_fields, $table_id){

        try {

            /**
             * Dynamically creating the query.
             */
            $select_query = "SELECT * FROM $table_name WHERE $table_fields[0] = :field_id";

            /**
             * Prepared Statement and execution.
             */
            $insert_stmt = $connection->prepare($select_query);
            $insert_stmt->execute(array(':field_id' => $table_id));

            $results = array();
            while($row = $insert_stmt->fetch(PDO::FETCH_NAMED)){
                array_push($results, $row);
            }
            return $results;

        } catch(PDOException $select_exception){
            $error_string = 'Insert Fail :: '.$select_query.PHP_EOL.
                'Table Fields given :: ('. implode(",", $table_fields) . ')' . PHP_EOL .
                'Named parameters :: (:field_id)'. PHP_EOL.
                'Values given :: ('. $table_id . ')' . PHP_EOL.
                'Database Message :: '.$select_exception->getMessage();
            $category = "SELECT_QUERIES";

            $err_handler = new LogErrorHandler($error_string, $category);
            $err_handler->createLogs();
//            include __DIR__."/../../../index.php";
//            exit;
        }

    }

    protected function process_update(CustomPDO $connection, $table_name, array $combined_array, array $table_id){

        /**
         * Initialize arrays for the insert.
         */
        $this->insert_arrays($combined_array);
        $update_string = $this->update_arrays($combined_array);

        try {

            /**
             * Dynamically creating the query.
             */
            $update_query = "UPDATE $table_name SET $update_string WHERE $table_id[0]=$table_id[1]";

            /**
             * Prepared Statement and execution.
             */
            $update_stmt = $connection->prepare($update_query);
            $update_stmt->execute($this->field_values);

        } catch(PDOException $insert_exception){
            $error_string = "Insert Fail :: $update_query" . PHP_EOL .
                "Update String :: ( $update_string )" . PHP_EOL .
                "Values given :: ( " . implode(",", $this->field_values) . ')' . PHP_EOL .
                'Database Message :: '. $insert_exception->getMessage();
            $category = "UPDATE_QUERIES";

            $err_handler = new LogErrorHandler($error_string, $category);
            $err_handler->createLogs();
            include __DIR__."/../../../../index.php";
//            exit;
        }
        //free stmt
    }

    protected function process_delete(CustomPDO $connection, $table_name, array $table_id){
        try {

            /**
             * Dynamically creating the query.
             */
            $delete_query = "DELETE FROM $table_name WHERE $table_id[0]=$table_id[1]";

            /**
             * Prepared Statement and execution.
             */
            $delete_stmt = $connection->prepare($delete_query);
            $delete_stmt->execute();

        } catch(PDOException $insert_exception){
            $error_string = "Insert Fail :: $delete_query" . PHP_EOL .
                "Values given :: ( " . implode(",", $table_id) . ')' . PHP_EOL .
                'Database Message :: '. $insert_exception->getMessage();
            $category = "DELETE_QUERIES";

            $err_handler = new LogErrorHandler($error_string, $category);
            $err_handler->createLogs();
//            include __DIR__."/../../../index.php";
//            exit;
        }
        //free stmt
    }

}