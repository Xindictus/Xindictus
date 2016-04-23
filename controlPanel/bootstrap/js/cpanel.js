/**
 * Created by Xindictus on 20/4/2016.
 */

var dbInfo = [];
var sessionInfo = [];
var statLoader = '<img src="img/220.gif">';
var versionT, dbT, sessionT, tableT, statusT, connectionT;

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
    if (a_components.length > b_components.length) {
        return 1;
    }

    if (a_components.length < b_components.length) {
        return -1;
    }

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
        var message = "You PHP Version supports Xindictus Library.";
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
                if(value == 0) {
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

    tableTimer++;
    setTimeout(function() {
        $('#refreshInfo').removeAttr('disabled');
    }, tableTimer*(seconds*2));
}

$(document).ready(function () {
    $('#refreshInfo').on('click', function () {
        resetInfo();
    });
    loadInfo();
});