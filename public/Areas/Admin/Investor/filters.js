app.filter("dateFilter", function () {
    return function (items, from, to) {
        var df = parseDate(from);
        var dt = parseDate(to);
        var returnCollection = [];
        for (var i = 0; i < items.length; i++) {
            var _df = new Date(items[i].start_date);
            var _dt = new Date(items[i].end_date);

            if (_df >= df && _dt <= dt) {
                returnCollection.push(items[i]);
            }
        }
        return returnCollection;
    };
});
function parseDate(input) {

    var parts = input.split('-');
    return new Date(parts[2], parts[1] - 1, parts[0]);
}

app.filter('newContractFilter', function (moment) {
    return function (items, obj) {
        function isBetween(date, start, end) {
            if (!end) {
                if (!start) return true;
                else return date.isSameOrAfter(start);
            }
            else {
                if (!start) return date.isSameOrBefore(end);
                else return date.isBetween(start, end);
            }
        }

        return _.filter(items, function (item) {

            if (!obj) {
                return true;
            }
            var start = moment(item.start_date);
            var end = moment(item.end_date);
            var act_start = moment(item.act_start_dt);
            var act_end = moment(item.act_end_dt);
            var car = item.car.reg_no.toUpperCase();
            var driver = item.driver.name.toLowerCase();
            var status = item.x_status.key.toLowerCase();

            var filtrate = true;
            filtrate = filtrate && isBetween(start, obj.start_date1, obj.start_date2);
            filtrate = filtrate && isBetween(end, obj.end_date1, obj.end_date2);
            filtrate = filtrate && isBetween(act_start, obj.act_start_date1, obj.act_start_date2);
            filtrate = filtrate && isBetween(act_end, obj.act_end_date1, obj.act_end_date2);
            filtrate = filtrate && (!obj.car_reg || car.includes(obj.car.reg_no.toUpperCase()));
            filtrate = filtrate && (!obj.driver_name || driver.includes(obj.driver.name.toLowerCase()));
            filtrate = filtrate && (!obj.status || status.includes(obj.status.toLowerCase()));


            return filtrate;
        });
    }
});


app.filter("driverFilter", function () {
    return function (items, text) {

        text = text.toLowerCase();

        var returnCollection = [];
        for (var i = 0; i < items.length; i++) {
            if(items[i].name) var _name = items[i].name.toLowerCase();
            else var _name = null;
            if(items[i].license_no) var _license = items[i].license_no.toLowerCase();
            else var _licence = null;
            if(items[i].pco_license_no) var _pco = items[i].pco_license_no.toLowerCase();
            else var _pco = null;
            if(items[i].email) var _email = items[i].email.toLowerCase();
            else var _email = null;
            if(items[i].phone) var _phone = items[i].phone.toLowerCase();
            else var _phone = null;
            if (_name.includes(text)
                || _license.includes(text)
                || _email.includes(text)
                || _phone.includes(text)
                || _pco.includes(text)) {
                returnCollection.push(items[i]);
            }
        }
        return returnCollection;
    };
});
