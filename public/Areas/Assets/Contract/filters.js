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