function filterTable() {
    let input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("inputFilter");
    filter = input.value.toUpperCase();
    table = document.getElementById("thisTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }    
    }
}

function filterTableStatus() {
    let input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("filterStatus");
    filter = input.value.toUpperCase();
    table = document.getElementById("thisTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[3];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }    
    }
}