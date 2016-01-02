$(function () {
    $('.key').on('click', function () {
        makeRequest($(this).data('key'));
    });

    $(document).keydown(function (e) {
        switch (e.which) {
            case 37:
                makeRequest('LEFT');
                break;
            case 38:
                makeRequest('UP');
                break;
            case 39:
                makeRequest('RIGHT');
                break;
            case 40:
                makeRequest('DOWN');
                break;
            case 13:
                makeRequest('ENTER');
                break;
            default:
                return;
        }
        e.preventDefault();
    });

    function makeRequest(parameters) {
        var url = 'samsungremote.php';
        parameters = '?key=' + parameters;
        if (window.XMLHttpRequest) {
            http_request = new XMLHttpRequest();
            if (http_request.overrideMimeType) {
                http_request.overrideMimeType('text/html');
            }
        }
        if (!http_request) {
            alert('Cannot create XMLHTTP instance');
            return false;
        }
        http_request.onreadystatechange = alertContents(http_request);
        http_request.open('GET', url + parameters, true);
        http_request.send(null);
    }

    function alertContents(http_request) {
        if (http_request.readyState == 4) {
            if (http_request.status != 200) {
                alert('There was a problem with the request.');
            }
        }
    }
});