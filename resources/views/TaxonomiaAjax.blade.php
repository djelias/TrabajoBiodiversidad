<!DOCTYPE html>
<html>
<head>
    <title>Laravel 5.8 Ajax CRUD funcional</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</head>
<body>
    
<div class="container">
    <h1>Laravel 5.8 Ajax CRUD funcional</h1>
    <a class="btn btn-success" href="javascript:void(0)" id="createNewTaxonomia"> Crear nueva taxonomia</a>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nombre</th>
                <th>Filum</th>
                <th>Familia</th>
                <th width="280px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
   
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="taxonomiaForm" name="taxonomiaForm" class="form-horizontal">
                   <input type="hidden" name="taxonomia_id" id="taxonomia_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nombre</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>
     
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Filum</label>
                        <div class="col-sm-12">
                            <textarea id="filum" name="filum" required="" placeholder="Enter filum" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Familia</label>
                        <div class="col-sm-12">
                            <textarea id="familia" name="familia" required="" placeholder="Enter familia" class="form-control"></textarea>
                        </div>
                    </div>
      
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    
</body>
    
<script type="text/javascript">
  $(function () {
     
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('ajaxtaxonomias.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'filum', name: 'filum'},
            {data: 'familia', name: 'familia'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
     
    $('#createNewTaxonomia').click(function () {
        $('#saveBtn').val("create-taxonomia");
        $('#taxonomia_id').val('');
        $('#taxonomiaForm').trigger("reset");
        $('#modelHeading').html("Create New Taxonomia");
        $('#ajaxModel').modal('show');
    });
    
    $('body').on('click', '.editTaxonomia', function () {
      var taxonomia_id = $(this).data('id');
      $.get("{{ route('ajaxtaxonomias.index') }}" +'/' + taxonomia_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Taxonomia");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#taxonomia_id').val(data.id);
          $('#name').val(data.name);
          $('#filum').val(data.filum);
          $('#familia').val(data.familia);
      })
   });
    
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
          data: $('#taxonomiaForm').serialize(),
          url: "{{ route('ajaxtaxonomias.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#taxonomiaForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });
    });
    
    $('body').on('click', '.deleteTaxonomia', function () {
     
        var taxonomia_id = $(this).data("id");
        confirm("Are You sure want to delete !");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('ajaxtaxonomias.store') }}"+'/'+taxonomia_id,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
     
  });
</script>
</html>