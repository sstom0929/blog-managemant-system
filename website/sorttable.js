function sortTable(n) {
    var tbody;
    var rows;
    var control = true;
    var i, x, y;
    var swap = false;
    var dir = 0;
    var switchcount = 0;
    while (control) {
        control = false;
        rows = $("tbody").children("tr");
        for (i = 0; i < (rows.length - 1); i++) {
            swap = false;
            x = rows[i].getElementsByTagName("td")[n];
            y = rows[i + 1].getElementsByTagName("td")[n];
            if (dir == 0) {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    swap= true;
                    break;
                }
            } else if (dir == 1) {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    swap = true;
                    break;
                }
            }
        }
        if (swap) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            control = true;
            switchcount = 1;      
        } else {
            if (switchcount == 0 && dir == 0) {
            dir = 1;
            control = true;
            }
        }
    }
}