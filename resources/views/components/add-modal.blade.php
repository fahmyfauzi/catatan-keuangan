<div class="modal fade" id="modal-add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">
                    <div class="mb-3">
                        <label for="keterangan" class="col-form-label">Keterangan:</label>
                        <input type="text" class="form-control" id="keterangan">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-keterangan"></div>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="col-form-label">Jumlah:</label>
                        <input type="text" class="form-control" id="jumlah">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-jumlah"></div>
                    </div>
                    <div class="mb-3">
                        <label for="jenis" class="col-form-label">Jenis:</label>
                        <select id="jenis" name="jenis" class="form-control">
                            <option disabled selected>---pilih jenis uang---</option>
                            </option>
                            <option value="masuk">Masuk</option>
                            <option value="keluar">Keluar</option>
                        </select>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-jenis"></div>
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="store">Submit</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('body').on('click', '#btn-add-money', function () {  
        //open modal
        $('#modal-add').modal('show');

    });

    $('#store').click(function(e){
        e.preventDefault();
        let user_id = $('#user_id').val()
        let keterangan = $('#keterangan').val();
        let jumlah = $('#jumlah').val();
        let jenis = $('#jenis').val();
        let token = $("meta[name='csrf-token']").attr("content");

        
        $.ajax({
            url:`moneys`,
            type:'post',
            cache: false,
            data:{
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
                    @if ($money->jenis == 'masuk')
                                <td class="bg-success text-white"><span>Rp. ${response.data.jumlah}</span></td>
                                <td>-</td>
                                @else
                                <td>-</td>
                                <td class="bg-warning text-white"><span>Rp.${response.data.jumlah}</span></td>
                                @endif
                    <td>${moment(response.data.created_at).fromNow()}</td>

                    <td>
                        <a href="javascript:void(0)" id="btn-edit-money" data-id="${response.data.id}"
                            class="btn btn-warning btn-sm">Edit</a>
                        <a href="javascript:void(0)" id="btn-delete-money" data-id="${response.data.id}"
                            class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                
            `;
            let jumlah = `
            <tr id="row-sum-moneys">
                                <th>Jumlah</th>
                                <td class=""><span>Rp.{{ $masuk }}</span></td>
                                <td class=""><span>Rp.{{ $keluar }}</span></td>
                                <td>Sisa</td>
                                <td>{{ $masuk - $keluar }}</td>
                            </tr>
            `;
             //masukan ke tabel
                $('#table-moneys').prepend(money);

                // replace ke penjumlahan
                $('#row-sum-moneys').replaceWith(jumlah);


                //clear form
                $('#user_id').val('');
                $('#keterangan').val('');
                $('#jumlah').val('');
                $('#jenis').val('');

                //close modal
                $('#modal-add').modal('hide');
            },
            error:function(error){
                if(error.responseJSON.keterangan[0]){
                    //show alert
                    $('#alert-keterangan').removeClass('d-none');
                    $('#alert-keterangan').addClass('d-block');
                    
                    //add message to alert
                    $('#alert-keterangan').html(error.responseJSON.keterangan[0]);
                }
                if(error.responseJSON.jumlah[0]){
                //show alert
                $('#alert-jumlah').removeClass('d-none');
                $('#alert-jumlah').addClass('d-block');
                
                //add message to alert
                $('#alert-jumlah').html(error.responseJSON.jumlah[0]);
                }
                if(error.responseJSON.jenis[0]){
                //show alert
                $('#alert-jenis').removeClass('d-none');
                $('#alert-jenis').addClass('d-block');
                
                //add message to alert
                $('#alert-jenis').html(error.responseJSON.jenis[0]);
                }
                
            }
            
        });
    });
</script>