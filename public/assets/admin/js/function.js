
function convertStringToDate(str) {
    var date = new Date(str);
    let options = {
        // weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
        // hour: "numeric",
        // minute: "numeric",
        // second: "numeric"
    };
    var newdate = date.toLocaleDateString('id', options);
    return newdate;
}

function convertStringToYMD(str) {
    var date = new Date(str);
    let options = {
        // weekday: "long",
        year: "numeric",
        month: "2-digit",
        day: "2-digit",
        // hour: "numeric",
        // minute: "numeric",
        // second: "numeric"
    };
    var newdate = date.toLocaleDateString('fr-CA', options);
    return newdate;
}
