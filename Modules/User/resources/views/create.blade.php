@extends('layouts.layout')
@section('content')

@include('layouts.breadcrumb')
    <section class="content">
        <div class="card card-primary">
            <form id="createFormUser">
                @csrf
                <div class="card-body">
                    <input type="hidden">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">email</label>
                        <input type="text" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="form-group col-3">
                        <label for="">Roles</label>
                      <select name="roles[]" class="form-control" size="3" multiple>
                        @foreach($roles as $role)
                        <option value="{{$role}}">{{$role}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                        <label for="password">password</label>
                        <input type="text" class="form-control" name="password" id="password" required>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button"onclick="window.location.href='{{ route('users.index') }}'"
                        class="btn btn-warning"><span>Back</span></button>
                </div>
            </form>
        </div>

    </section>
@endsection
@section('script')
<script>
  $(document).ready(() => {

      // const Toast = Swal.mixin({
      //     toast: true,
      //     position: 'top-end',
      //     showConfirmButton: false,
      //     timer: 3000
      // });

      // const showToast = (icon, message) => {
      //     Toast.fire({
      //         icon: icon,
      //         title: message
      //     });
      // };
      toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right", // Posisi toast
            "timeOut": "2000",
          
        };

        const showToast = (icon, message) => {
            if (icon === 'error') {
                toastr.error(message); // Toast untuk error
            } else if (icon === 'success') {
                toastr.success(message); // Toast untuk sukses
            } else if (icon === 'info') {
                toastr.info(message); // Toast untuk info
            } else {
                toastr.warning(message); // Toast untuk warning
            }
        };

      $('#createFormUser').on('submit', function(e) {
          e.preventDefault();
          $.ajax({
              url: '/users/store',
              type: 'POST',
              data: $(this).serialize(),
              success: function(data) {
                  window.location.href = '/users/edit/' + data.data;
              },
              error: (xhr) => {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        // Iterasi untuk semua error
                        for (const [field, messages] of Object.entries(errors)) {
                            messages.forEach(message => {
                                showToast('error', message);
                                // console.log(message); 
                            });
                        }
                    } else {
                        showToast('error', 'An unexpected error occurred.');
                    }
                }
          });
      });
  });
</script>

@endsection
