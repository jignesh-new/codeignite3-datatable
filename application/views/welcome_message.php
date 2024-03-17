<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Registration Form</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!-- DataTables CSS -->
  <link href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
  <!-- User Table -->
  <h1>Datatable Codeigniter3</h1>
  <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Start Date</th>
                <th>End Date</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Start Date</th>
                <th>End Date</th>
            </tr>
        </tfoot>
    </table>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.print.min.js"></script>

<!-- <script>
$(document).ready(function() { 
    $('#example').DataTable({
        info: false,
        ordering: false,
        paging: true,
        ajax: {
            url: '<?= base_url("welcome/datatable");?>',
        },
        columns: [
            { data: 'username' },
            { data: 'email' },
            { data: 'created_at'}
        ],
        "initComplete" : function(){
					var notApplyFilterOnColumn = [3];
					var inputFilterOnColumn = [0];
					var showFilterBox = 'afterHeading'; //beforeHeading, afterHeading
					$('.gtp-dt-filter-row').remove();
					var theadSecondRow = '<tr class="gtp-dt-filter-row">';
					$(this).find('thead tr th').each(function(index){
						theadSecondRow += '<td class="gtp-dt-select-filter-' + index + '"></td>';
					});
					theadSecondRow += '</tr>';

					if(showFilterBox === 'beforeHeading'){
						$(this).find('thead').prepend(theadSecondRow);
					}else if(showFilterBox === 'afterHeading'){
						$(theadSecondRow).insertAfter($(this).find('thead tr'));
					}

					this.api().columns().every( function (index) {
						var column = this;

						if(inputFilterOnColumn.indexOf(index) >= 0 && notApplyFilterOnColumn.indexOf(index) < 0){
							$('td.gtp-dt-select-filter-' + index).html('<input type="text" class="gtp-dt-input-filter">');
			                $( 'td input.gtp-dt-input-filter').on( 'keyup change clear', function () {
			                    if ( column.search() !== this.value ) {
			                        column
			                            .search( this.value )
			                            .draw();
			                    }
			                } );
						}else if(notApplyFilterOnColumn.indexOf(index) < 0){
							var select = $('<select><option value="">Select</option></select>')
			                    .on( 'change', function () {
			                        var val = $.fn.dataTable.util.escapeRegex(
			                            $(this).val()
			                        );
			 
			                        column
			                            .search( val ? '^'+val+'$' : '', true, false )
			                            .draw();
			                    } );
			                $('td.gtp-dt-select-filter-' + index).html(select);
			                column.data().unique().sort().each( function ( d, j ) {
			                    select.append( '<option value="'+d+'">'+d+'</option>' )
			                } );
						}
					});
				} 
       
    });
    
});

</script> -->
<script>

    
    $(document).ready(function() {
        
    $('#example').DataTable({
        info: false,
        ordering: false,
        paging: true,
        ajax: {
            url: '<?= base_url("welcome/datatable");?>',
        },
        columns: [
            { data: 'username' },
            { data: 'email' },
            { data: 'start_date'},
            { data: 'end_date'},
        ],
        layout: {
        topStart: {
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        }
    },
        initComplete: function () {
        this.api()
            .columns()
            .every(function (index) {
                let column = this;

                // Create select element
                if(index==0){
                    let select = document.createElement('select');
                    select.add(new Option(''));
                    column.header().replaceChildren(select);
    
                    // Apply listener for user change in value
                    select.addEventListener('change', function () {
                        column
                            .search(select.value, {exact: true})
                            .draw();
                    });
    
                    // Add list of options
                    column
                        .data()
                        .unique()
                        .sort()
                        .each(function (d, j) {
                            select.add(new Option(d));
                        });
                }
                else if(index==1){
                    let column = this;
                    let title = column.header().textContent;
    
                    // Create input element
                    let input = document.createElement('input');
                    input.placeholder = title;
                    column.header().replaceChildren(input);
    
                    // Event listener for user input
                    input.addEventListener('keyup', () => {
                        if (column.search() !== this.value) {
                            column.search(input.value).draw();
                        }
                    });
                } else if (index == 2) {
                        let title = column.header().textContent;

                        // Create input element
                        let input = document.createElement('input');
                        input.type = "date";
                        input.placeholder = title;
                        column.header().replaceChildren(input);

                        // Event listener for user input
                        input.addEventListener('change', () => {
                            column.search(input.value).draw();
                        });
                    }
                    else if (index == 3) {
                        let title = column.header().textContent;

                        // Create input element
                        let input = document.createElement('input');
                        input.type = "date";
                        input.placeholder = title;
                        column.header().replaceChildren(input);

                        // Event listener for user input
                        input.addEventListener('change', () => {
                            column.search(input.value).draw();
                        });
                    }
                
            });
    }
    
        // initComplete: function() {
        //     var notApplyFilterOnColumn = [3];
        //     var inputFilterOnColumn = [0];
        //     var showFilterBox = 'afterHeading'; // beforeHeading, afterHeading
        //     $('.gtp-dt-filter-row').remove();
        //     var theadSecondRow = '<tr class="gtp-dt-filter-row">';
        //     $(this).find('thead tr th').each(function(index) {
        //         theadSecondRow += '<td class="gtp-dt-select-filter-' + index + '"></td>';
        //     });
        //     theadSecondRow += '</tr>';

        //     if (showFilterBox === 'beforeHeading') {
        //         $(this).find('thead').prepend(theadSecondRow);
        //     } else if (showFilterBox === 'afterHeading') {
        //         $(theadSecondRow).insertAfter($(this).find('thead tr'));
        //     }

        //     this.api().columns().every(function(index) {
        //         var column = this;

        //         if (notApplyFilterOnColumn.indexOf(index) < 0) {
        //             if (inputFilterOnColumn.indexOf(index) >= 0) {
        //                 $('td.gtp-dt-select-filter-' + index).html('<input type="text" class="gtp-dt-input-filter">');
        //                 $('td input.gtp-dt-input-filter').on('keyup change clear', function() {
        //                     if (column.search() !== this.value) {
        //                         column.search(this.value).draw();
        //                     }
        //                 });
        //             } else if (index === 1) { // Second column, email
        //                 var select = $('<select><option value="">Select</option></select>')
        //                     .on('change', function() {
        //                         var val = $.fn.dataTable.util.escapeRegex(
        //                             $(this).val()
        //                         );

        //                         column
        //                             .search(val ? '^' + val + '$' : '', true, false)
        //                             .draw();
        //                     });
        //                 $('td.gtp-dt-select-filter-' + index).html(select);
        //                 column.data().unique().sort().each(function(d, j) {
        //                     select.append('<option value="' + d + '">' + d + '</option>')
        //                 });
        //             } else if (index === 2) { // Third column, created_at
        //                 $('td.gtp-dt-select-filter-' + index).html('<input type="date" class="gtp-dt-date-filter">');
        //                 $('td input.gtp-dt-date-filter').on('change', function() {
        //                     column.search(this.value).draw();
        //                 });
        //             }
        //         }
        //     });
        // }
    });
});

</script>
</body>
</html>
