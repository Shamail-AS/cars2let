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