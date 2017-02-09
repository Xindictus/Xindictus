<?php
/******************************************************************************
 * Copyright (c) 2016 Konstantinos Vytiniotis, All rights reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 *
 * File: frameworkExample.php
 * User: Konstantinos Vytiniotis
 * Email: konst.vyti@hotmail.com
 * Date: 22/11/2016
 * Time: 03:19
 *
 ******************************************************************************/
//NAMESPACES WE ARE GOING TO USE
use Indictus\Database\dbHandlers;
use Indictus\Model;
use Indictus\Cache\BugDB;
use Indictus\General;

/* INCLUDING AUTOLOADER - ALWAYS ON TOP OTHERWISE CLASSES WON'T LOAD */
require_once(__DIR__ . "/../xindictus.lib/xindictus.config/AutoLoader/AutoLoader.php");

/* BLOCK CACHING OF PAGE */
General\CacheBlocker::cacheBlock();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->

    <meta name="author" content="Konstantinos Vytiniotis">

    <title>Framework Example</title>

    <link rel="stylesheet" href="../controlPanel/bootstrap/css/bootstrap.min.css" type="text/css">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="panel panel-info">
            <div class="panel-heading text-center">
                <h4>
                    Connection to Database
                </h4>
            </div>
            <div class="panel-body">
                <?php
                /* OPENING A NEW CONNECTION */
                echo "~ Open a new Connection to database BusinessDays";
                $connection = dbHandlers\DatabaseConnection::startConnection('BusinessDays');
                echo "<br><hr>";

                echo "~ Check if connection succeeded: ";
                echo ($connection->isConnected() == 0) ? "Successful" : "Unsuccessful";
                echo "<br><hr>";

                /* CLOSING CONNECTION */
                echo "~ Trying to close connection: ";
                echo (dbHandlers\DatabaseConnection::closeConnection($connection) == 0) ? "Closed successfully" : "Failed to close connection";
                ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading text-center">
                <h4>
                    Queries
                </h4>
            </div>
            <div class="panel-body">
                <?php
                echo "~ Open a new Connection to database BusinessDays";
                $connection = dbHandlers\DatabaseConnection::startConnection('BusinessDays');
                $connection2 = dbHandlers\DatabaseConnection::startConnection('BugDB');
                echo "<br><hr>";

                echo "<h4>~ INSERT</h4><hr>";
                /**
                 * INSERT
                 */
                if ($connection->isConnected() != -1) {

                    try {
                        /* BEGINS TRANSACTION WITH DATABASE */
                        /* USEFUL WHEN INSERTING WITH DEPENDENCIES */
                        $connection->beginTransaction();

                        echo "~ Creating a new Test Object<br>";
                        /* 2 WAYS TO CREATE OBJECT WITH VALUES */
                        /* 1. THROUGH THE CONSTRUCTOR */
                        //$examples = new Model\TestObject("New Test Event B3333", 1985);

                        /* 2. THROUGH THE SETTERS OF THE CLASS - PREFERRED FOR
                         * CLARIFICATION REASONS AND EASE OF CODE READING
                         */
                        $test = new Model\TestObject();
                        $test
                            ->setEventName("Panorama2")
                            ->setEventYear(2017);

                        /* SETTING THE CONNECTION PROPERTY OF OUR OBJECT */
                        echo "~ Setting connection<br>";
                        $test->setConnection($connection);


                        /* INSERTING OBJECT TO DATABASE
                         * RETURNS -1 FOR FAILURE, 0 FOR SUCCESS
                         */
                        echo "~ Testing insertion of examples: ";
                        //    echo $examples->insert() ? "Failure" : "Success";
                        if ($test->insert() < 0)
                            throw new Exception("error inserting record");
                        else
                            echo "Inserted successfully.";

                        /* USE FOR TRANSACTION EXAMPLE */
                        //        $test
                        //            ->setEventName("Panorama2")
                        //            ->setEventYear(2017);
                        //        if ($test->insert() < 0)
                        //            throw new Exception("error inserting record");

                        echo "<br><br>";

                        /* COMMIT CHANGES TO DATABASE */
                        $connection->commit();

                    } catch (Exception $exception) {
                        $connection->rollBack();
                        echo "Failed: " . $exception->getMessage();
                        echo "<br><hr>";
                    }
                }
                /*-------------------------------------------------------*/
                /**
                 * 2ND EXAMPLE WITH INSERT
                 */
                //if ($connection2->isConnected() != -1) {
                //
                //    try {
                //        $connection2->beginTransaction();
                //
                //        $tag = new BugDB\Tag("Neaw Tasdfest 1Event233K3333");
                //        $tag->setConnection($connection2);
                //
                //        echo "Testing insertion of tag: ";
                //        //echo $tag->insert() ? "Failure" : "Success";
                //        if ($tag->insert() < 0)
                //            throw new Exception("duplicatora");
                //        else
                //            echo "Success";
                //        echo "<br><br>";
                //
                //        $connection2->commit();
                //
                //    } catch (Exception $exception) {
                //        $connection2->rollBack();
                //        echo "Failed: " . $exception->getMessage();
                //        echo "<br><br>";
                //    }
                //}

                /**
                 * SELECT
                 */
                if ($connection->isConnected() != -1) {
                    /* SELECT ALL RECORDS */
                    $testResult = $test->select();
                    echo "<h4>~ SELECT</h4><hr>";
                    foreach ($testResult as $event) {
                        echo "{$event->getEventId()} | {$event->getEventName()} | {$event->getEventYear()}<br>";
                    }
                    echo "------------------------------<br>";
                    /*SELECT ALL RECORDS WITH EVENT_NAME "PANORAMA" */
                    $testResult = $test->select(array(
                        "event_name" => "New Test Event"
                    ));
                    foreach ($testResult as $event) {
                        echo "{$event->getEventId()} | {$event->getEventName()} | {$event->getEventYear()}<br>";
                    }
                    echo "------------------------------<br>";
                    /*SELECT EVENT_ID, EVENT NAME FROM ALL RECORDS WHERE EVENT_NAME IS "PANORAMA" */
                    $testResult = $test->select(array(
                        "event_name" => "New Test Event"
                    ), "event_id, event_name");
                    foreach ($testResult as $event) {
                        echo "{$event->getEventId()} | {$event->getEventName()} | {$event->getEventYear()}<br>";
                    }
                }
                echo "<hr>";
                /**
                 * UPDATE
                 */
                if ($connection->isConnected() != -1) {
                    echo "<h4>~ UPDATE</h4><hr>";
                    echo "N/A";
                    /**
                     * @param 1st: an array with keys the tables fields to be updated and
                     * values of the array the new values of the record.
                     * @param 2nd: an array with keys the tables fields to search for update
                     * and values of the array the values to search for.
                     */
                    //    $result = $test->update(
                    //        array(
                    //            'event_name' => 'Updated Event',
                    //            'event_year' => 1991
                    //        ),
                    //        array(
                    //            'event_id' => 27
                    //        )
                    //    );
                    //    echo ($result) ? "Nothing was updated or sth else went wrong<br>"
                    //        : "Record(s) updated successfully.<br>";

                }
                echo "<hr>";
                /**
                 * DELETE
                 */
                if ($connection->isConnected() != -1) {
                    echo "<h4>~ DELETE</h4><hr>";
                    /* DELETE BY COLUMN AND VALUE */
                    $result = $test->delete(array(
                        'event_year' => 2016
                    ));

                    echo ($result) ? "Nothing was deleted or sth else went wrong<br>"
                        : "Record(s) deleted successfully.<br>";
                    /* DELETE BY MULTIPLE COLUMNS AND VALUES */
                    $result = $test->delete(array(
                        'event_year' => '1995',
                        'event_id' => 59
                    ));

                    echo ($result) ? "Nothing was deleted or sth else went wrong<br>"
                        : "Record(s) deleted successfully.<br>";
                }
                ?>
            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading text-center">
                <h4>
                    Other Queries
                </h4>
            </div>
            <div class="panel-body">
                <?php
                /**
                 * OTHER USEFUL METHODS
                 */
                /* TOTAL COLUMNS OF TABLE */
                echo "Total no. of columns for table \"" . $test::TABLE_NAME . "\": {$test->columnCount()}<br>";
                /* # OF ROWS */
                echo "Total no. of rows for table \"" . $test::TABLE_NAME . "\": {$test->rowCount()}<br>";
                /* LAST INSERTED ID */
                echo "Last inserted id in table \"" . $test::TABLE_NAME . "\": {$test->lastInsertId()}<br>";
                /* LAST INSERTED EVENT NAME */
                /**
                 * NOT WORKING NOR INTENDED - WORKS AS A COMPARISON METHOD FOR THE REST COLUMNS TO
                 * RETURN THE BIGGEST NUMBER OF ALPHANUMERICAL STRING
                 */
                //echo "Last inserted `event_name` in table \"" . $examples::TABLE_NAME . "\": {$examples->lastInsertId(2)}<br>";
                ?>
            </div>
        </div>
    </div>
</div>

</body>
</html>


