<div class="modal fade" id="modal-edit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form action="#" method="POST" autocomplete="off" id="form-edit" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" placeholder="Enter name" />
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" placeholder="Enter email" />
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control" />
                        <span>Please fill in if you want to update the image</span>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{old('password')}}" autocomplete="new-password" placeholder="Enter password">
                        <span>Please fill in the password if you want to change it</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-light-primary btn-reset font-weight-bold" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('new-script')
    <script>
        $('#form-edit').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this)
            $.ajax({
                url: $('#form-edit').attr('action'),
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                type: "POST",
                dataType: 'json',
                success: function (data) {
                if (data.status) {
                    Swal.fire({
                        text: "Successfully saved data",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Oke",
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-light-primary"
                        }
                    }).then(function() {
                        $('#form-edit').trigger('reset');
                        $('#form-edit .btn-reset').trigger('click');
                        window.table.ajax.reload();
                    });
                }else{
                    let errorList = [];
                    $.each(data.errors, function (key, val) {
                        errorList.push(val)
                    });
                    Swal.fire({
                        text: errorList.join(),
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-light-primary"
                        }
                    });
                }
                
                }
            });
        });
    </script>
@endpush