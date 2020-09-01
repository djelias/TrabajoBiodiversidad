<!DOCTYPE html>
<html>
<head>
    <title>Laravel 5.8 Ajax CRUD investigacion</title>
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
    <h1>Laravel 5.8 Ajax CRUD investigacion</h1>
    <a class="btn btn-success" href="javascript:void(0)" id="createNewInvestigacion"> Crear nueva investigacion</a>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Descripcion</th>
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
                <form id="investigacionForm" name="investigacionForm" class="form-horizontal">
                   <input type="hidden" name="investigacion_id" id="investigacion_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nombre</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>
     
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Fecha</label>
                        <div class="col-sm-12">
                            <textarea id="fecha" name="fecha" required="" placeholder="Enter filum" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Descripcion</label>
                        <div class="col-sm-12">
                            <textarea id="descripcion" name="descripcion" required="" placeholder="Enter familia" class="form-control"></textarea>
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
        ajax: "{{ route('ajaxinvestigaciones.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'nombre', name: 'nombre'},
            {data: 'fecha', name: 'fecha'},
            {data: 'descripcion', name: 'descripcion'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
     
    $('#createNewInvestigacion').click(function () {
        $('#saveBtn').val("create-investigacion");
        $('#investigacion_id').val('');
        $('#investigacionForm').trigger("reset");
        $('#modelHeading').html("Create New Investigacion");
        $('#ajaxModel').modal('show');
    });
    
    $('body').on('click', '.editInvestigacion', function () {
      var investigacion_id = $(this).data('id');
      $.get("{{ route('ajaxinvestigaciones.index') }}" +'/' + investigacion_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Investigacion");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#investigacion_id').val(data.id);
          $('#nombre').val(data.nombre);
          $('#fecha').val(data.fecha);
          $('#descripcion').val(data.descripcion);
      })
   });
    
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
          data: $('#investigacionForm').serialize(),
          url: "{{ route('ajaxinvestigaciones.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#investigacionForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });
    });
    
    $('body').on('click', '.deleteInvestigacion', function () {
     
        var investigacion_id = $(this).data("id");
        confirm("Are You sure want to delete !");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('ajaxinvestigaciones.store') }}"+'/'+investigacion_id,
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