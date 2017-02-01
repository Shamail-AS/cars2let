app.filter("dateFilter",function(){
    return function(items,from,to){
        var df = new Date(from);
        var dt = new Date(to);
        var returnCollection = [];
        for(var i = 0; i < items.length; i++)
        {
            var _df = new Date(items[i].start_date);
            var _dt = new Date(items[i].end_date);

            if(_df >= df && _dt <= dt){
                returnCollection.push(items[i]);
            }
        }
        return returnCollection;
    };
});
//DEPRECATED//
app.filter("contractFilter", function () {
    return function (items, text) {

        text = text.toLowerCase();

        var returnCollection = [];
        for (var i = 0; i < items.length; i++) {
            var _reg_no = items[i].car.reg_no.toLowerCase();
            var _driver_name = items[i].driver.name.toLowerCase();
            var _status = items[i].x_status.key.toLowerCase();
            if (_driver_name.includes(text)
                || _reg_no.includes(text)
                || _status.includes(text)) {
                returnCollection.push(items[i]);
            }
        }
        return returnCollection;
    };
});
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
            var car = item.car.reg_no.toLowerCase();
            var driver = item.driver.name.toLowerCase();
            var status = item.x_status.key.toLowerCase();

            var filtrate = true;
            filtrate = filtrate && isBetween(start, obj.start_date1, obj.start_date2);
            filtrate = filtrate && isBetween(end, obj.end_date1, obj.end_date2);
            filtrate = filtrate && isBetween(act_start, obj.act_start_date1, obj.act_start_date2);
            filtrate = filtrate && isBetween(act_end, obj.act_end_date1, obj.act_end_date2);
            filtrate = filtrate && (!obj.car_reg || car.includes(obj.car_reg));
            filtrate = filtrate && (!obj.driver_name || driver.includes(obj.driver_name));
            filtrate = filtrate && (!obj.status || status.includes(obj.status));


            return filtrate;
        });
    }
});
