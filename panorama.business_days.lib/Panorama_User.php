<?php
/**
 * Created by PhpStorm.
 * User: Kotsos
 * Date: 9/12/2015
 * Time: 10:32
 */

/**
 *  Extend Panorama_User with CRUD class.
 */
include_once(__DIR__ . "/../../xindictus.lib/xindictus.database/crudHandlers/lulz.php");
include_once(__DIR__ . "/../../xindictus.lib/xindictus.filtering/validationHandlers/Validator.php");
include_once(__DIR__ . "/../../xindictus.lib/xindictus.filtering/sanitization_handlers/Sanitizer.php");

class Panorama_User extends SimpleCRUD implements Validator, Sanitizer{

    /**
     * Defining DATABASE, TABLE_NAME and table_fields of the class.
     */
    const DATABASE = "business_days";
    private static $TABLE_NAME = "panorama_user";

    /**
     * The table fields as private members of the class representing the table.
     */
    protected static $table_fields = array('panorama_user_id', 'first_name',
        'last_name', 'father_name', 'birthday', 'gender');

    /**
     * @var $panorama_user_id: User's unique id.
     * @var $first_name: User's first name.
     * @var $last_name: User's last name.
     * @var $father_name: User's father's name.
     * @var $birthday: User's birthday.
     * @var $gender: User's gender.
     */
    protected $panorama_user_id;
    protected $first_name;
    protected $last_name;
    protected $father_name;
    protected $birthday;
    protected $gender;

    /**
     * Panorama_User constructor.
     * @param null $first_name
     * @param null $last_name
     * @param null $father_name
     * @param null $birthday
     * @param null $gender
     * @param null $panorama_user_id
     */
    public function __construct($first_name = NULL, $last_name = NULL,
                                $father_name = NULL, $birthday = NULL,
                                $gender = NULL, $panorama_user_id = NULL){
        $this->panorama_user_id = $panorama_user_id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->father_name = $father_name;
        $this->birthday = $birthday;
        $this->gender = $gender;
    }

    function strip_user_input(){
        $this->first_name = strip_tags($this->first_name);
        $this->last_name = strip_tags($this->last_name);
        $this->father_name = strip_tags($this->father_name);
        $this->birthday = strip_tags($this->birthday);
        $this->gender = strip_tags($this->gender);
        echo $this->first_name." ".$this->last_name." ".$this->father_name." ".$this->birthday." ".$this->gender."<br>";
    }


    function validate_user_input(){
        $this->first_name = filter_var($this->first_name, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
        $this->last_name = filter_var($this->last_name, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
        $this->father_name = filter_var($this->father_name, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
        $this->birthday = filter_var($this->birthday);
        $this->gender = filter_var($this->gender);
        echo $this->first_name." ".$this->last_name." ".$this->father_name." ".$this->birthday." ".$this->gender."<br>";
    }

    function sanitize_user_input(){
    }


    /**
     * @param mixed $panorama_user_id
     */
    public function setPanoramaUserId($panorama_user_id){
        $this->panorama_user_id = $panorama_user_id;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name){
        $this->first_name = $first_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name){
        $this->last_name = $last_name;
    }

    /**
     * @param mixed $father_name
     */
    public function setFatherName($father_name){
        $this->father_name = $father_name;
    }

    /**
     * @param mixed $birthday
     */
    public function setBirthday($birthday){
        $this->birthday = $birthday;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender){
        $this->gender = $gender;
    }

    /**
     * @param CustomPDO $connection
     * @return int
     */
    public function process_insert($connection){

        /**
         * Call parent process_insert to perform insert query.
         */
        return parent::process_insert($connection, self::$TABLE_NAME, $this->construct_insert_values());
    }

    public function process_select($connection){

        /**
         * Call parent process_insert to perform insert query.
         */
        return parent::process_select($connection, self::$TABLE_NAME, self::$table_fields, $this->panorama_user_id);
    }

    public function process_update($connection, array $update_fields){

        /**
         * Call parent process_update to perform update query.
         */
        parent::process_update($connection, self::$TABLE_NAME, $this->construct_update_values($update_fields), array(self::$table_fields[0],$this->panorama_user_id));
    }

    public function process_delete($connection){

        /**
         * Call parent process_delete to perform delete query.
         */
        parent::process_delete($connection, self::$TABLE_NAME, array(self::$table_fields[0],$this->panorama_user_id));
    }


}