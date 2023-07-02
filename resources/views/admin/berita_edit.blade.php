@extends('admin.layouts.base')
@section('title', 'Edit Berita')
@section('path')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item">Berita</li>
<li class="breadcrumb-item active">Edit</li>
@endsection
@section('content')
<form action="{{ url('admin/berita/'.$b->id_berita) }}" method="post">
    @csrf
    @method('PUT')
    <div class="row">
    <div class="col-lg-8">
        <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Deskripsi</h3>
            <div class="card-tools">
            <a href="#" class="btn btn-tool" title="Previous"><i class="fas fa-chevron-left"></i></a>
            <a href="#" class="btn btn-tool" title="Next"><i class="fas fa-chevron-right"></i></a>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
            <textarea class="mailbox-read-message @error('deskripsi') is-invalid @enderror" name="deskripsi">{{ $b->deskripsi }}</textarea>
            @error('deskripsi')
            <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
            </span>
            @enderror
            <!-- /.mailbox-read-message -->
        </div>
        <!-- /.card-footer -->
        
        <!-- /.card-footer -->
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-primary">
        <div class="card-body">
            <div class="form-group">
            <label for="judul">Judul Berita</label>
            <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ $b->judul }}" placeholder="Masukkan Judul">
            @error('judul')
            <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
            </span>
            @enderror
            </div>
            <div class="form-group">
            <label for="slug">Slug</label>
            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ $b->slug }}" placeholder="Masukkan slug">
            @error('slug')
            <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
            </span>
            @enderror
            </div>
            <div class="card-footer">
            <input type="submit" class="btn btn-primary" name="submit" value="Simpan">
            @if(!$b->status_publikasi)
            <input type="submit" class="btn btn-success" name="submit" value="Publish">
            @else
            <input type="submit" class="btn btn-danger" name="submit" value="Unpublish">
            @endif
            </div>
        </div>
    </div>                                         
    </div>
</form>
@endsection
@section('javascript')
<script>
    $(function() {
      var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });
  
      @error('gagal')
      $(function() {
        Toast.fire({
          icon: 'error',
          title: '{{ $message }}'
        })
      });
      @enderror
      @if(session('berhasil'))
      $(function() {
        Toast.fire({
          icon: 'success',
          title: '{{ session("berhasil") }}'
        })
      });
      @endif
    });
  </script>
  <script src="https://cdn.tiny.cloud/1/bzjvrcrq915qupv46s8mrirjufpb853d0ikmidyluiq50c62/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
      
  <script>
          tinymce.init({
            selector: 'textarea',
            plugins: 'autolink codesample emoticons lists charmap image code codesample link lists searchreplace table visualblocks wordcount',
            toolbar: 'undo redo blocks fontfamily fontsize bold italic underline strikethrough | removeformat emoticons charmap link image table mergetags codesample align lineheight numlist bullist indent outdent',
            /* enable title field in the Image dialog*/
            image_title: true,
            height : "1000",
              /* enable automatic uploads of images represented by blob or data URIs*/
            automatic_uploads: true,
            images_upload_url: '{{ url('api/uploadgambarberita/'.$b->id_berita) }}',
              /*
                  URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
                  images_upload_url: 'postAcceptor.php',
                  here we add custom filepicker only to Image dialog
              */
              file_picker_types: 'image',
              /* and here's our custom image picker*/
              file_picker_callback: function (cb, value, meta) {
                  var input = document.createElement('input');
                  input.setAttribute('type', 'file');
                  input.setAttribute('accept', 'image/*');
  
                  /*
                  Note: In modern browsers input[type="file"] is functional without
                  even adding it to the DOM, but that might not be the case in some older
                  or quirky browsers like IE, so you might want to add it to the DOM
                  just in case, and visually hide it. And do not forget do remove it
                  once you do not need it anymore.
                  */
  
                  input.onchange = function () {
                  var file = this.files[0];
  
                  var reader = new FileReader();
                  reader.onload = function () {
                      /*
                      Note: Now we need to register the blob in TinyMCEs image blob
                      registry. In the next release this part hopefully won't be
                      necessary, as we are looking to handle it internally.
                      */
                      var id = 'blobid' + (new Date()).getTime();
                      var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                      var base64 = reader.result.split(',')[1];
                      var blobInfo = blobCache.create(id, file, base64);
                      blobCache.add(blobInfo);
  
                      /* call the callback and populate the Title field with the file name */
                      cb(blobInfo.blobUri(), { title: file.name });
                  };
                  reader.readAsDataURL(file);
                  };
  
                  input.click();
              },
              setup: function(editor) {
                  editor.on("keydown", function(e){
                      if ((e.keyCode == 8 || e.keyCode == 46) && tinymce.activeEditor.selection) {
                          var selectedNode = tinymce.activeEditor.selection.getNode();
                          if (selectedNode && selectedNode.nodeName == 'IMG') {
                              var imageSrc = selectedNode.src;
                              var xhr = new XMLHttpRequest();
                              xhr.open('POST', '/api/deletegambarberita', true);
                              xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                              xhr.onreadystatechange = function() {
                                  if (xhr.readyState === 4) {
                                  if (xhr.status === 200) {
                                      console.log('Image deleted');
                                  } else {
                                      console.error('Failed to delete image', xhr.status, xhr.statusText);
                                  }
                                  }
                              };
                              xhr.send('image-url=' + encodeURIComponent(imageSrc));
                          }
                      }
                  });
              }
          });
  </script>
  <script>
      $(document).ready(function() {
      // Get the judul and slug inputs
      const $judulInput = $("#judul");
      const $slugInput = $("#slug");
  
      // Add an event listener to the judul input
      $judulInput.on("input", function() {
          // Get the value of the judul input
          const judulValue = $judulInput.val();
  
          // Convert the judul value to lowercase and replace spaces with dashes
          const slugValue = judulValue.toLowerCase().replace(/\s+/g, "-");
  
          // Set the value of the slug input to the new slug value
          $slugInput.val(slugValue);
      });
      });
  </script> 
@endsection