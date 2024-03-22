<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" >
</head>
<body>

    
    <div class="w-50 mx-auto">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            Add Contact
          </button>
        <table id="contact_tbl" class="table">
            <thead>
              <tr>
                <th scope="col">Fullname</th>
                <th scope="col">Email</th>
                <th scope="col">Mobile Number</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
    </div>


  
  <!-- Modal -->
  <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Add Contact</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="fullname" placeholder="fullname">
                <label for="floatingInput">Fullname</label>
              </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
              </div>
              <div class="form-floating">
                <input type="password" class="form-control" id="mobileNum" placeholder="mobileNum">
                <label for="floatingmobileNum">Mobile Number</label>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" id="add" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>



  
  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="editFullname" placeholder="fullname">
                <label for="floatingInput">Fullname</label>
            </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="editEmail" placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control" id="editMobileNum" placeholder="mobileNum">
                <label for="floatingmobileNum">Mobile Number</label>
            </div>
            <input type="hidden" id="contactId">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" id="updateBtnModal" class="btn btn-primary">Update</button>
        </div>
      </div>
    </div>
  </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(function(){
            const table = $('#contact_tbl').DataTable({
                processing: false,
                serverSide: false,
                destroy: true,
                ajax: {
                    url: '{{route("getData")}}',
                    dataSrc: ''
                },
                columns: [ 
                    {
                        data: 'fname'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'mobileNum'
                    },
                    {
                        data: 'action'
                    },
                 ]
            });

            $("#add").click(function(){
                const fname = $("#fullname").val();
                const email = $("#email").val();
                const mobileNum = $("#mobileNum").val();

                $.ajax({
                    url: '{{route("insert")}}',
                    method: 'post',
                    data: {
                        fname, email, mobileNum,
                        _token: "{{csrf_token()}}"
                    },
                    success(){
                        table.ajax.reload();
                        $("#addModal").modal('hide')
                    }
                })

            })

            $(document).on('click','#updateBtn', function(){
                const id = $(this).data('id');
                const fname = $(this).data('fullname');
                const email = $(this).data('email');
                const mobileNum = $(this).data('mobilenum');

                $("#editFullname").val(fname);
                $("#editEmail").val(email);
                $("#editMobileNum").val(mobileNum);
                $("#contactId").val(id)

            })

            $("#updateBtnModal").click(function(){
                const id = $("#contactId").val();
                const fname = $("#editFullname").val();
                const email = $("#editEmail").val();
                const mobileNum = $("#editMobileNum").val();

                $.ajax({
                    url: '{{route("update")}}',
                    method: 'post',
                    data: {
                        id, fname, email, mobileNum,
                        _token: "{{csrf_token()}}"
                    },
                    success(){
                        table.ajax.reload();
                        $("#editModal").modal('hide')
                    }
                })
            })

      
            
            $(document).on('click','#deleteBtn', function(){
                const id = $(this).data('id');

                $.ajax({
                    url: '{{route("delete")}}',
                    method: 'post',
                    data: {
                        id,
                        _token: "{{csrf_token()}}"
                    },
                    success(){
                        table.ajax.reload();
                    }
                })

            })
        })
    </script>
</body>
</html>