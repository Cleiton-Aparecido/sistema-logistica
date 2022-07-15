

function submitformentrega(){
    
    if(document.getElementById('status').value == 'null' || document.getElementById('dataentrega').value == "" ){
        alert('A campos vazios');
    }
    else{
        document.getElementById("formealterarstatusentrega").submit();
    }
};





$(document).ready(function () {

    $('#table_master').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
    });
   

}); 