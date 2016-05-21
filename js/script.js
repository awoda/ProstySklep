function checkThis(str) {
    var num = new Number(str);
    if (/^[0-9]{0,10}(\.[0-9]{0,2})?$/.test(str) && num > 0) {
        document.getElementById("button").disabled = false;
    } else {
        document.getElementById("button").disabled = true;
        alert('Błędna wartość ceny');
        
    }
}