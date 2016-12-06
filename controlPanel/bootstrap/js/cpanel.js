/**
 * Created by Xindictus on 20/4/2016.
 */

var dbInfo = [];
var sessionInfo = [];
var statLoader = '<img src="img/220.gif">';
var versionT, dbT, sessionT, tableT, statusT, connectionT, dbObjectsT;

//INITIALIZE TOOLTIP'S POP-UPs
function initTooltip() {
    $('[data-toggle="tooltip"]').tooltip({
        placement: 'top'
    });
}

function compare(a, b) {
    if (a === b) {
        return 0;
    }

    var a_components = a.split(".");
    var b_components = b.split(".");

    var len = Math.min(a_components.length, b_components.length);

    // loop while the components are equal
    for (var i = 0; i < len; i++) {
        // A bigger than B
        if (parseInt(a_components[i]) > parseInt(b_components[i])) {
            return 1;
        }

        // B bigger than A
        if (parseInt(a_components[i]) < parseInt(b_components[i])) {
            return -1;
        }
    }

    // If one's a prefix of the other, the longer one is greater.
    if (a_components.length > b_components.length)
        return 1;

    if (a_components.length < b_components.length)
        return -1;

    // Otherwise they are the same.
    return 0;
}

function fillTable(table, fileName, prefix, info) {
    $.ajax({
        type: 'GET',
        url: 'controllers/'+fileName+'.php',
        dataType: 'json',
        cache: false
    }).done( function( data ) {
        info = data;

        //FILL TABLES WITH LIBRARY INFO
        $('#'+prefix+'InfoLoader').fadeOut();

        var timer = 0;
        $.each(data, function(key) {
            timer++;
            tableT = setTimeout(function(){
                var eleID = key + prefix.charAt(0).toUpperCase() + prefix.slice(1) + "ID";
                var shownKEY = key.charAt(0).toUpperCase() + key.slice(1);
                $('#'+table)
                    .find('tbody:last')
                    .append('<tr><td><code><b>'+shownKEY+'</b></code></td><td id="'+eleID+'">'+statLoader+'</td></tr>');
            }, timer*200);
        });
        setTimeout(function(){
            fillStatus(info, prefix);
        }, timer*200+1000);
    });
}

function fillStatus(info, prefix) {
    var val;
    var timer = 0;
    $.each(info, function(key, value) {
        timer++;
        statusT = setTimeout(function() {
            var selectedTD = $("#" + key + prefix.charAt(0).toUpperCase() + prefix.slice(1) + "ID");
            selectedTD.empty();
            val = value;
            if (val !== "" && val !== null) {
                if (typeof value === "object") {
                    val = "";
                    $.each(value, function (configKey, configValue) {
                        val += configKey + " : " + configValue + "\n";
                    });
                }

                selectedTD.addClass("td-success").html('SET').attr({
                    "data-toggle": "tooltip",
                    title: val
                });

            }
            else if (val === ""){
                selectedTD.addClass('td-fail').html('NOT SET');
            }
            else {
                selectedTD.addClass('td-null').html('NULL');
            }
            initTooltip();
        }, timer*200);
    });
}

function selectAll(obj) {
    $(obj).siblings('form')
        .find('input')
        .prop("checked", true);
}

function clearAll(obj) {
    $(obj).siblings('form')
        .find('input')
        .prop("checked", false);
}

function resetInfo() {
    clearInterval(versionT);
    clearInterval(dbT);
    clearInterval(sessionT);
    clearInterval(tableT);
    clearInterval(statusT);
    clearInterval(connectionT);
    $("#version").empty().append('<img id="versionLoader" src="img/724.gif">');
    $('#dbInfoLoader').fadeIn();
    $('#sessionInfoLoader').fadeIn();
    $('tbody').empty();
    $('#alertPanel').empty().append('<img id="alertLoader" src="img/379.gif">');
    $('#actionPanel').empty().append('<img id="actionLoader" src="img/379.gif">');
    $('#modalB').empty();
    loadInfo();
}

function loadInfo() {
    var tableTimer = 1;
    var seconds = 1000;
    var phpVer = 0;

    $('#refreshInfo').attr('disabled', 'true');

    $.ajax({
        type: 'GET',
        url: 'controllers/frameVersion.php',
        dataType: 'json',
        cache: false
    }).done( function( version ) {
        $('#frameVersion').html(version);
    });

    versionT = setTimeout(function(){
        var span = '<a href="phpINFO.php"><span class="glyphicon glyphicon-share-alt" title="PHP Info"></span></a>';
        $.ajax({
            type: 'GET',
            url: 'controllers/getVersion.php',
            dataType: 'json',
            cache: false
        }).done( function( data ) {
            $("#versionLoader").remove();
            $("#version").append('<h4>PHP Version: ' + data + ' ' + span + '</h4>').hide().fadeIn('slow');
            phpVer = data;
        });
    }, tableTimer*seconds);

    tableTimer++;
    dbT = setTimeout(function(){
        fillTable('tableDB', 'fillTableDB', 'db', dbInfo);
    }, tableTimer*seconds);

    tableTimer++;
    sessionT = setTimeout(function(){
        fillTable('tableSes', 'fillTableSession', 'session', sessionInfo);
    }, tableTimer*seconds);

    var alerts = $('#alertPanel');

    tableTimer++;
    setTimeout(function() {
        var className = "alert alert-success";
        var message = "Your PHP Version supports Xindictus Library.";
        if(compare(phpVer, "5.3.25") == -1){
            className = "alert alert-danger";
            message = "You should have at least PHP Version >= 5.3.25 to use Xindictus Library.";
        }

        alerts.find('#alertLoader').remove();
        alerts.append('<div class="'+className+'" role="alert">'+message+'</div>');

    }, tableTimer*(seconds*2));

    connectionT = setTimeout(function() {
        $.ajax({
            type: 'GET',
            url: 'controllers/getConnectionStatus.php',
            dataType: 'json',
            cache: false
        }).done( function( status ) {
            $.each(status, function (key, value) {
                var className = "alert alert-success";
                var message = "Connection with database \"" + key +
                    "\" has been established.";
                if (value != 0) {
                    className = "alert alert-danger";
                    message = "Connection with database \"" + key +
                        "\" could not be established.<br>" +
                        "Check your username and password or database definition in \"config.php\".";
                }
                alerts.find('#alertLoader').remove();
                alerts.append('<div class="'+className+'" role="alert">'+message+'</div>');
            });
        });
    }, tableTimer*(seconds*2));

    var actions = $('#actionPanel');

    dbObjectsT = setTimeout(function() {
        $.ajax({
            type: 'GET',
            url: 'controllers/getDatabaseInfo.php',
            dataType: 'json',
            cache: false
        }).done( function( status ) {
            console.log(status);
            var ul = $('<ul></ul>')
                .addClass('nav nav-tabs');
            var content = $('<div></div>')
                .addClass('tab-content');

            var actionBtn = $('<div></div>')
                .addClass('text-center')
                .append('<button class="btn btn-primary action-btn" onclick="selectAll(this.parentNode);">Select All</button>')
                .append('<button class="btn btn-warning action-btn" onclick="clearAll(this.parentNode);">Clear All</button>')
                .append('<hr>');

            var submitBtn = $('<div></div>')
                .addClass('text-center')
                .append('<div class="clearfix"></div>')
                .append('<hr>')
                .append('<input class="btn btn-info" type="submit" value="Submit">');

            var pos = 0;
            $.each(status, function (key, value) {

                if (pos == 0)
                    ul
                        .append('<li class="active"><a data-toggle="tab" href="#'+key+'">'+key+'</a></li>');
                else
                    ul
                        .append('<li><a data-toggle="tab" href="#'+key+'">'+key+'</a></li>');

                var tab = $('<div></div>')
                    .attr('id', key);

                if (pos == 0)
                    tab
                        .addClass('tab-pane active');
                else
                    tab
                        .addClass('tab-pane');

                tab
                    .append(actionBtn.clone());

                pos = 1;

                var dbCheck = $('<form method="POST" action="controllers/createClass.php"></form>');
                var leftC = $('<div></div>')
                    .addClass('col-md-4 text-right');
                var middleC = $('<div></div>')
                    .addClass('col-md-4 text-right');
                var rightC = $('<div></div>')
                    .addClass('col-md-4 text-right');
                $.each(value, function (index, tableName) {

                    switch (pos) {
                        case 1:
                            leftC
                                .append(tableName+' <input type="checkbox" name="tableName_'+index+'" value="'+tableName+'"><br>');
                            break;
                        case 2:
                            middleC
                                .append(tableName+' <input type="checkbox" name="tableName_'+index+'" value="'+tableName+'"><br>');
                            break;
                        case 3:
                            rightC
                                .append(tableName+' <input type="checkbox" name="tableName_'+index+'" value="'+tableName+'"><br>');
                            break;
                    }

                    if (pos < 3)
                        pos++;
                    else
                        pos = 1;
                });
                dbCheck
                    .append('<input type="text" class="form-key" name="formDB" value="'+key+'">')
                    .append('<input type="text" class="form-key" name="numDB" value="'+value.length+'">')
                    .append(leftC)
                    .append(middleC)
                    .append(rightC)
                    .append(submitBtn.clone());

                tab
                    .append(dbCheck);

                content
                    .append(tab);
            });
            actions.find('#actionLoader').remove();
            actions
                .append(ul)
                .append(content);
        });
    }, tableTimer*(seconds*2));

    tableTimer++;
    setTimeout(function() {
        $('#refreshInfo').removeAttr('disabled');
    }, tableTimer*(seconds*2));

    $.ajax({
        type: 'GET',
        url: 'controllers/dirFiles.php',
        dataType: 'json',
        cache: false
    }).done( function ( obj ) {
        // var keys = Object.keys(obj);
        var link = $('<a></a>')
            .addClass('link-pointer')
            .attr('data-toggle', 'collapse')
            .attr('data-parent', '#myModal');

        var span = $('<span></span>')
            .addClass('glyphicon glyphicon-chevron-right');

        var collapse = $('<div></div>')
            .addClass('collapse');
        var clearfix = $('<div></div>')
            .addClass('clearfix');
        var content = $('<div></div>');

        $.each(obj, function (key, array) {
            span
                .prop('id', key+'Span');

            content
                .append(
                    link
                        .clone()
                        .prop('id', key+'Link')
                        .prop('value', '0')
                        .attr('data-target', '#'+key+'Modal')
                        .append(span.clone())
                        .append(key));

            var htmlArr = $('<p></p>');
            $.each(array, function (arrK, arrV) {
                htmlArr
                    .append((parseInt(arrK)+1) + ". " + arrV + "<br>");
            });

            content
                .append(
                    collapse
                        .clone()
                        .prop('id', key+'Modal')
                        .html(htmlArr)
                );
            content
                .append(clearfix.clone());
        });
        // console.log(obj[keys[0]]);
        $('#modalB')
            .append(content);

        $('.link-pointer').on('click', function () {
            var spanId = $(this).prop('id').slice(0, -4) + 'Span';
            var spanEl = $('#'+spanId);

            if ($(this).prop('value') == '0') {
                spanEl.removeClass('glyphicon-chevron-right').addClass('glyphicon-chevron-down');
                $(this).prop('value', '1');
            } else {
                spanEl.removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-right');
                $(this).prop('value', '0');
            }
        });
    });
}

// function toggleGlyph(obj) {
//     $(obj).toggleClass("glyphicon-chevron-down");
//     $(obj).toggleClass("glyphicon-chevron-up");
// }

$(document).ready(function () {
    $('#refreshInfo').on('click', function () {
        resetInfo();
    });
    loadInfo();

});