app.filter("dateFilter",function(){
    return function(items,from,to){
        var df = parseDate(from);
        var dt = parseDate(to);
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
function parseDate(input) {

    var parts = input.split('-');
    return new Date(parts[2], parts[1]-1, parts[0]);
}
app.filter("driverFilter", function () {
    return function (items, text) {

        text = text.toLowerCase();

        var returnCollection = [];
        for (var i = 0; i < items.length; i++) {
            var _name = items[i].name.toLowerCase();
            if(!items[i].license_no)
                var _license  = '';
            else 
                var _license = items[i].license_no.toLowerCase();
            if(!items[i].pco_license_no)
                var _pco = '';
            else
                var _pco = items[i].pco_license_no.toLowerCase();
            var _email = items[i].email.toLowerCase();
            var _phone = items[i].phone.toLowerCase();
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
