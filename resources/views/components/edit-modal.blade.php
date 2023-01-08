<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" id="user_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" id="money_id">
                    <div class="mb-3">
                        <label for="keterangan_edit" class="col-form-label">Keterangan:</label>
                        <input type="text" class="form-control" id="keterangan_edit">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-keterangan-edit"></div>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah-edit" class="col-form-label">Jumlah:</label>
                        <input type="text" class="form-control" id="jumlah_edit">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-jumlah-edit"></div>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_edit" class="col-form-label">Phone:</label>
                        <select id="jenis_edit" name="jenis" class="form-control">
                            <option disabled selected>---pilih jenis uang---</option>
                            </option>
                            <option value="masuk">Masuk</option>
                            <option value="keluar">Keluar</option>
                        </select>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-phone"></div>
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="storeEdit">Submit</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('body').on('click', '#btn-edit-money', function () {  
        //open modal
        let money_id = $(this).data('id');

        $.ajax({
            url:`/moneys/${money_id}`,
            type:'GET',
            cache:false,
            success:function(response){
                $('#money_id').val(response.data.id);
                $('#keterangan_edit').val(response.data.keterangan);
                $('#jumlah_edit').val(response.data.jumlah);
                $('#jenis_edit').val(response.data.jenis);
                $('#modal-edit').modal('show');
            }
        });


    });

    $('#storeEdit').click(function(e){
        e.preventDefault();
        let money_id = $('#money_id').val();
        let user_id = $('#user_id').val();
        let keterangan = $('#keterangan_edit').val();
        let jumlah = $('#jumlah_edit').val();
        let jenis = $('#jenis_edit').val();
        let token = $("meta[name='csrf-token']").attr("content");

        $.ajax({
            url:`moneys/${money_id}`,
            type:'PUT',
            cache: false,
            data:{
                'id':money_id,
                'user_id':user_id,
                'keterangan':keterangan,
                'jumlah':jumlah,
                'jenis':jenis,
                '_token':token,
            },
            success:function(response){
                                //show success message
               Swal.fire({
                    title: 'success!',
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    timer:2000
                 })

            let money = `
            <tr id="index_${response.data.id}">
                    <td>${response.data.keterangan}</td>
                    <td>${response.data.jumlah}</td>
                    <td>${response.data.jenis}</td>
                    <td>${moment(response.data.created_at).fromNow()}</td>

                    <td>
                        <a href="javascript:void(0)" id="btn-edit-contact" data-id="${response.data.id}"
                            class="btn btn-warning btn-sm">Edit</a>
                        <a href="javascript:void(0)" id="btn-delete-contact" data-id="${response.data.id}"
                            class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            `;
             //masukan ke tabel
                $(`#index_${response.data.id}`).replaceWith(money);

                //close modal
                $('#modal-edit').modal('hide');
            },
            error:function(error){
                if(error.responseJSON.keterangan[0]){
                    //show alert
                    $('#alert-keterangan-edit').removeClass('d-none');
                    $('#alert-keterangan-edit').addClass('d-block');
                    
                    //add message to alert
                    $('#alert-keterangan-edit').html(error.responseJSON.keterangan[0]);
                }
                if(error.responseJSON.jumlah[0]){
                //show alert
                $('#alert-jumlah-edit').removeClass('d-none');
                $('#alert-jumlah-edit').addClass('d-block');
                
                //add message to alert
                $('#alert-jumlah-edit').html(error.responseJSON.jumlah[0]);
                }
                if(error.responseJSON.jenis[0]){
                //show alert
                $('#alert-jenis-edit').removeClass('d-none');
                $('#alert-jenis-edit').addClass('d-block');
                
                //add message to alert
                $('#alert-jenis-edit').html(error.responseJSON.phone[0]);
                }
                
            }
            
        });
    });
</script>