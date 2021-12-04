 @extends('layouts.app')
 @section('content')
 <div class="container">
     <div class="row">
         <div class="col-8">
             <div class="card">
                 <div class="card-body">
                     <table class="table">
                         <thead class="table-dark">
                             <tr>
                                 <th scope="col">#</th>
                                 <th scope="col">name</th>
                                 <th scope="col">title</th>
                                 <th scope="col">Institute</th>
                                 <th scope="col">Action</th>
                             </tr>
                         </thead>
                         <tbody>
                             <!-- <tr>
                                 <th scope="row">1</th>
                                 <td>Mark</td>
                                 <td>Otto</td>
                                 <td>@mdo</td>
                                 <td><a href="" class="btn btn-sm btn-danger">delete</a> <a href="" class="btn btn-sm btn-success"> edit</td>
                             </tr> -->

                         </tbody>
                     </table>
                 </div>
             </div>

         </div>
         <div class="col-4">
             <div class="card">
                 <div class="card-body">
                     <div class="card-header">
                         <h4>
                             <span id="addT">Add new teacher</span>
                             <span id="updateT">Update teacher</span>
                         </h4>
                     </div>

                     <div class="form-group my-1">
                         <label class="form-label" for="">name</label>
                         <input type="text" class="form-control" id="name" placeholder="name" />
                     </div>
                     <span class="text-danger" id="nameError"> </span>

                     <div class="form-group my-1">
                         <label class="form-label" for="">title</label>
                         <input type="text" class="form-control" id="title" placeholder="title" />
                     </div>
                     <span class="text-danger" id="titleError"> </span>

                     <div class="form-group my-1">
                         <label class="form-label" for=""> institute</label>
                         <input type="text" class="form-control" id="institute" placeholder="institute" />
                     </div>
                     <span class="text-danger" id="instituteError"> </span>

                     <input type="hidden" id="id">
                     <button class="btn btn-sm btn-primary btn-inline-block my-1" id="addbutton" onclick="addData()">Add</button> <button class="btn btn-sm btn-primary btn-inline-block" id="updatebutton" onclick="updateData()">update</button>
                 </div>
             </div>
         </div>
     </div>
 </div>
 @endsection

 @section('script')
 <script>
     $('#addT').show();
     $('#addbutton').show();
     $('#updateT').hide();
     $('#updatebutton').hide();

     $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     });

     //  get all data
     function alldata() {
         $.ajax({
             type: 'get',
             dataType: 'json',
             url: 'teacher/all',
             success: function(response) {
                 var data = ""
                 $.each(response, function(key, value) {
                     data = data + "<tr>";
                     data = data + "<th>" + value.id + "</th>";
                     data = data + "<td>" + value.name + "</td>";
                     data = data + "<td>" + value.title + "</td>";
                     data = data + "<td>" + value.institute + "</td>";
                     data = data + "<td>"
                     data = data + "<button type='button' class='btn btn-sm btn-danger' onclick='deleteData(" + value.id + ")'> delete </button> <button type='button' class='btn btn-sm btn-success' onclick='editData(" + value.id + ")'> edit </button>"
                     data = data + "</td>"
                     data = data + "</tr>";
                 });
                 $('tbody').html(data);
             }

         });

     }

     alldata();
     // end get data

     // start clear data

     function clearData() {
         $('#name').val('');
         $('#title').val('');
         $('#institute').val('');
         $('#nameError').text('');
         $('#titleError').text('');
         $('#instituteError').text('');
     }
     //    end clear data

     //  start store data
     function addData() {
         var name = $('#name').val();
         var title = $('#title').val();
         var institute = $('#institute').val();

         $.ajax({
             type: 'post',
             dataType: 'json',
             data: {
                 name: name,
                 title: title,
                 institute: institute
             },
             url: 'teacher/store',
             success: function(data) {
                 alldata();
                 clearData();
                 //  start alert

                 //   end alert
                 alert('successfully data added');
             },
             error: function(error) {
                 $('#nameError').text(error.responseJSON.errors.name);
                 $('#titleError').text(error.responseJSON.errors.title);
                 $('#instituteError').text(error.responseJSON.errors.institute);
             }

         });
     }
     // end store data


     //    edit data
     function editData(id) {
         $.ajax({
             type: 'get',
             datatype: 'json',
             url: 'teacher/edit/' + id,
             success: function(data) {

                 $('#addT').hide();
                 $('#addbutton').hide();
                 $('#updateT').show();
                 $('#updatebutton').show();

                 $('#id').val(data.id);
                 $('#name').val(data.name);
                 $('#title').val(data.title);
                 $('#institute').val(data.institute);
             }

         });
     }
     // end edit data

     //  update data
     function updateData() {
         var id = $('#id').val();
         var name = $('#name').val();
         var title = $('#title').val();
         var institute = $('#institute').val();

         $.ajax({
             type: "post",
             datatype: "json",
             data: {
                 name: name,
                 title: title,
                 institute: institute
             },

             url: 'teacher/update/' + id,
             success: function(data) {
                 $('#addT').show();
                 $('#addbutton').show();
                 $('#updateT').hide();
                 $('#updatebutton').hide();
                 alldata();
                 clearData();
                 console.log('data updated successfully');
             },
             error: function(error) {
                 $('#nameError').text(error.responseJSON.errors.name);
                 $('#titleError').text(error.responseJSON.errors.title);
                 $('#instituteError').text(error.responseJSON.errors.institute);
             }
         });
     }
     // end data

     //  delete data
     function deleteData(id) {
       if (confirm('do you want to delete data?')) {
             
             var name = $('#name').val();
             var title = $('#title').val();
             var institute = $('#institute').val();

             $.ajax({
                 url: 'teacher/delete/'+ id,
                 type: 'delete',
                 datatype: 'json',
                 data: {
                     name: name,
                     title: title,
                     institute: institute,
                 },
                 success: function(data) {
                    alldata();
                    clearData();
                 },
             });
         } else {
         }
     }
 </script>
 @endsection