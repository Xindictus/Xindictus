/**
 * Created by Xindictus on 28/6/2016.
 */

function returnCP() {
    window.location.href = '../';
}

function updateProgress(val, table) {
    var textField = $('#progressText');
    var divField = $('#progressDiv');
    var consoleDiv = $('#consoleUpdate');
    var newVal = parseFloat(textField.text().slice(0, -1)) + Math.ceil(val);
    var consoleText = consoleDiv.html() + 'File created for table `' + table + '` . . .\n';

    if (newVal > 100)
        newVal = 100;

    textField.text(newVal + '%');
    divField.css('width', newVal+'%');
    consoleDiv.html(consoleText).focus();
}