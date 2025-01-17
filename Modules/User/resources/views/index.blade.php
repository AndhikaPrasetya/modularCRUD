@extends('layouts.layout')
@section('content')
    <div class="p-3">

    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="d-flex justify-content-between align-items-center px-3 mt-4">

                            <div>
                                <h3 class="card-title align-items-center">Data Post</h3>
                            </div>
                            <div>
                                <a href="{{ route('users.create') }}" class="btn btn-primary">Create</a>

                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                              
                                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-info btn-sm"> <i class="icon-pencil"></i> <span>Edit</span></a>
                                                    <button type="button" class="btn btn-outline-danger btn-sm delete-button" data-id="{{$user->id }}" data-section="users">
                                                    <i class="fa fa-trash-o"></i> Delete</button>
                                                    
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
@section('script')
    <script>
          $(document).on('click', '.delete-button', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let section = $(this).data('section');

            let url = `/${section}/delete/${id}`;
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success"
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function() {
                            Swal.fire("Error!", "There was a problem deleting the item.",
                                "error");
                        }
                    });
                }
            });
        });
    </script>
@endsection

