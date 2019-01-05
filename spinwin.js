var log = function() {
    // body...
    console.log.apply(console, arguments);
}

$(function() {
    $('#pointer').on('click', function(e) {
        // body...
        lottery();
    });
});

var lottery = function() {
    // body...
    var request = {
        type: 'POST',
        url: './spinWin.php',
        dataType: 'json',
        cache: false,
        error: function() {
            alert('出错了！');
            return false;
        },
        success: function(json) {
            $("#pointer").unbind('click').css("cursor", "default");
            //ajax传回的角度
            var a = json.angle;
            //ajax传回的奖项
            var p = json.prize;
            $("#pointer").rotate({
                //转动时间3秒
                duration: 3000,
                angle: 0,
                //转动角度5圈
                animateTo: 1800 + a, //转动角度
                easing: $.easing.easeOutSine,
                callback: function() {
                    var con = confirm('恭喜你，中得' + p + '\n还要再来一次吗？');
                    if (con) {
                        lottery();
                    } else {
                        $(this).on('click', function(e) {
                            // body...
                            lottery();
                        });
                    };
                },
            });
        },
    };
    $.ajax(request);
}