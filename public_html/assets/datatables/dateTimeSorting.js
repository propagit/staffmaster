$.extend(jQuery.fn.dataTableExt.oSort, {
    "datetime-au-pre": function (a) {
        var x;
        if ($.trim(a) != '') {
            var frDatea = $.trim(a).split(' ');
            var frTimea = frDatea[1].split(':');
            var frDatea2 = frDatea[0].split('/');
            var year = frDatea2[2];
            var month = frDatea2[1];
            var day = frDatea2[0];
            var hour = frTimea[0];
            var minute = frTimea[1];
            var second = frTimea[2];
            var ampm = frDatea[2];
 
            if (day < 10) {
                day = '0' + day;
            }
 
            if (ampm == 'PM' && hour < 12) {
                hour = parseInt(hour, 10) + 12;
            }
 
            if (hour < 10) {
                hour = '0' + hour;
            }
 
            x = (year + month + day + hour + minute + second) * 1;
        } else {
            x = 10000000000000;
        }
 
        return x;
    },
 
    "datetime-au-asc": function (a, b) {
        return a - b;
    },
 
    "datetime-au-desc": function (a, b) {
        return b - a;
    }
});