<!DOCTYPE html>
<html>
  <head>
    <!-- Meta-->
    <meta charset="utf-8">
    <meta author="" content="Andy Tran">
    <!-- Title-->
    <title>Login Form - UI Library</title>
    <!-- Fonts-->
    <link type="text/css" media="screen" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700">
    <!-- Stylesheet-->
    <!-- Favicon -->
    <link href="images/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">  

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="assets/lib/animate/animate.min.css" rel="stylesheet">
    <link href="assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

    <!-- Template Stylesheet -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link type="text/css" media="screen" rel="stylesheet" href="assets/css/main-login.css">
    <style>
      #chatbot {
        z-index: 1000;
        position: fixed !important;
      }
      .title{
        margin:auto;
        font-size:x-large;
        font-family: Raleway, sans-serif;
        color: rgb(11, 2, 72);
      }
      @media (min-width: 450px) {
            .main-card {
              width: 96%;
              max-width: 400px;
              height: calc(100% - 32px) !important;
              border-radius: 8px !important;
              max-height: 600px;
            margin: 16px!important;
            }
          }

          .collapsed {
            width: 48px !important;
            height: 48px !important;
            border-radius: 24px !important;
            margin: 16px!important;
          }

          .main-card {
            background: white;
            color: white;
            width: 100%;
            height: 100%;
            margin: 0px;
            border-radius: 0px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            right: 0;
            bottom: 0;
            position: absolute;
            transition: all 0.5s;
            box-shadow: 0 10px 16px 0 rgba(0, 0, 0, 0.2),0 6px 20px 0 rgba(0, 0, 0, 0.19);
          }
      #chatbot_toggle {
        position: absolute;
        right: 0;
        border: none;
        height: 48px;
        width: 48px;
        background: rgb(236, 220, 0);
        padding: 14px;
        color:rgb(0, 0, 0);
      }
      #chatbot_toggle:hover {
        background: rgb(236, 220, 0);
      }
      .line {
        height: 1px;
        background-color: rgb(11, 2, 72);
        width: 100%;
        opacity: 0.2;
      }
      .main-title {
        background-color: rgb(11, 2, 72);
        font-size: large;
        font-weight: bold;
        display: flex;
        height: 48px;
      }
      .main-title>div{
        height:48px;
        width:48px;
        display:flex;
        margin-left:8px;
      }
      .main-title svg {
        height: 24px;
        margin: auto;
      }
      .main-title > span {
        margin: auto auto auto 8px;
      }
      .chat-area {
        flex-grow: 1;
        overflow: auto;
        border-radius: 8px;
        padding: 16px;
        display: flex;
        flex-direction: column;
      }
      .input-message {
        padding: 8px 48px 8px 16px;
        flex-grow: 1;
        border: none;
      }
      .input-message:focus {
        outline: none;
      }
      .input-div {
        height: 48px;
        display: flex;
      }

      .input-send {
        background: transparent;
        width: 48px;
        height: 48px;
        right: 0%;
        border: none;
        cursor: pointer;
      }
      .input-send:hover {
        background: lavender;
      }
      .input-send svg {
        fill: rgb(236, 220, 0);;
        margin: 11px 8px;
      }
      .chat-message-div {
        display: flex;
      }

      .chat-message-sent {
        background-color: white;
        margin: 8px 16px 8px 64px;
        padding: 8px 16px;
        animation-name: fadeIn;
        animation-iteration-count: 1;
        animation-timing-function: ease-in;
        animation-duration: 100ms;
        color: black;
        border-radius: 8px 8px 2px 8px;
        background-color: lavender;
      }

      .chat-message-received {
        background-color: white;
        margin: 8px 64px 8px 16px;
        padding: 8px 16px;
        animation-name: fadeIn;
        animation-iteration-count: 1;
        animation-timing-function: ease-in;
        animation-duration: 100ms;
        color: black;
        border-radius: 8px 8px 8px 2px;
        background-color: lavender;
      }

      @keyframes fadeIn {
        from {
          opacity: 0;
        }

        to {
          opacity: 1;
        }
      }

      ::-webkit-scrollbar {
        width: 10px;
      }
      ::-webkit-scrollbar-track {
        background: #f1f1f1;
      }

      ::-webkit-scrollbar-thumb {
        background: #888;
      }

      ::-webkit-scrollbar-thumb:hover {
        background: #555;
      }  
    </style>
  </head>
  <body>
    <!-- if there are login errors, show them here -->
    <div class="black-bg"></div>
    <!-- Form-->
    <div class="form">
      <!-- Form Toggle-->
      <div class="form-toggle"></div>
      <!-- Form Panel (One)-->
      <div class="form-panel one">
        <!-- Form Header-->
        <div class="form-header">
          <h1>Login sekarang</h1>
        </div>
        <!-- Form Content-->
        <div class="form-content">
          <form id="loginform" action="{{ url('/login') }}" method="post">
            @csrf
            <!-- Form Group-->
            <div class="form-group">
              <label for="email">E-mail</label>
              <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Masukkan emailmu" required>
              @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <!-- Form Group-->
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password" name="password" required>
              @error('password')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <!-- Form Group-->
            <div class="form-group">
              <button type="submit">Log In</button>
            </div>
          </form>
            <!-- Form Group-->
            <div class="form-group" style="margin-top: 15px">
              <span>Belum punya akun?‎ </span>
              <a class="form-recovery" href="{{ url('register') }}" style="cursor: pointer;"> Register disini </a>
              <span>‎ sebagai mahasiswa</span>
            </div>
        </div>
      </div>
      <!-- Form Panel (Two)-->
      <div class="form-panel two">
        <!-- Form Header-->
        <div class="form-header">
          <h1>Daftar sekarang</h1>
        </div>
        <!-- Form Content-->
        <div class="form-content">
          <form id="registerform" action="{{ url('/register') }}" method="post" enctype="multipart/form-data">
            @csrf
            <!-- Form Group-->
            <div class="form-group">
              <label for="nama">Nama lengkap</label>
              <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" placeholder="Masukkan nama lengkapmu" required>
              @error('nama')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <!-- Form Group-->
            <div class="form-group">
              <label for="nim">NIM</label>
              <input type="text" id="nim" name="nim" class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim') }}" placeholder="Masukkan NIM mu" required>
              @error('nim')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="form-group">
              <label for="no_telp">Nomor Telepon</label>
              <input type="text" id="no_telp" name="no_telp" class="form-control @error('no_telp') is-invalid @enderror" value="{{ old('no_telp') }}" placeholder="Masukkan nomor teleponmu" required>
              @error('no_telp')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <!-- Form Group-->
            <div class="form-group">
              <label for="email">E-mail</label>
              <input type="email" id="emailr" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Masukkan emailmu" required>
              @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <!-- Form Group-->
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" id="passwordr" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password" required>
              @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <!-- Form Group-->
            <div class="form-group">
              <label for="password_confirmation">Konfirmasi Password</label>
              <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Konfirmasi Password" required>
              @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="form-group">
              <label for="krs">KRS</label>
              <input type="file" id="krs" name="krs" class="form-control @error('krs') is-invalid @enderror" required>
              @error('krs')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="form-group">
              <label for="transkrip">Transkrip</label>
              <input type="file" id="transkrip" name="transkrip" class="form-control @error('transkrip') is-invalid @enderror" required>
              @error('transkrip')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="form-group">
              <label for="bukti_seminar">Bukti mengikuti seminar (optional)</label>
              <input type="file" id="bukti_seminar" name="bukti_seminar" class="form-control @error('bukti_seminar') is-invalid @enderror" required>
              @error('bukti_seminar')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <!-- Form Group-->
            <div class="form-group">
              <button type="submit">Daftar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div id="chatbot" class="main-card collapsed">
      <button id="chatbot_toggle">
        <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" fill="currentColor"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M15 4v7H5.17l-.59.59-.58.58V4h11m1-2H3c-.55 0-1 .45-1 1v14l4-4h10c.55 0 1-.45 1-1V3c0-.55-.45-1-1-1zm5 4h-2v9H6v2c0 .55.45 1 1 1h11l4 4V7c0-.55-.45-1-1-1z"/></svg>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="display:none"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/></svg>
      </button>
      <div class="main-title">
        <div>
          <svg viewBox="0 0 640 512" title="robot">
            <path fill="currentColor" d="M32,224H64V416H32A31.96166,31.96166,0,0,1,0,384V256A31.96166,31.96166,0,0,1,32,224Zm512-48V448a64.06328,64.06328,0,0,1-64,64H160a64.06328,64.06328,0,0,1-64-64V176a79.974,79.974,0,0,1,80-80H288V32a32,32,0,0,1,64,0V96H464A79.974,79.974,0,0,1,544,176ZM264,256a40,40,0,1,0-40,40A39.997,39.997,0,0,0,264,256Zm-8,128H192v32h64Zm96,0H288v32h64ZM456,256a40,40,0,1,0-40,40A39.997,39.997,0,0,0,456,256Zm-8,128H384v32h64ZM640,256V384a31.96166,31.96166,0,0,1-32,32H576V224h32A31.96166,31.96166,0,0,1,640,256Z" />
          </svg>
        </div>
        <span>Chatbot</span>
      </div>
      <div class="chat-area" id="message-box">
      </div>
      <div class="line"></div>
      <div class="input-div">
        <input class="input-message" name="message" type="text" id="message" placeholder="Type your message ..." />
        <button class="input-send" onclick="send()">
          <svg style="width:24px;height:24px">
            <path d="M2,21L23,12L2,3V10L17,12L2,14V21Z" />
          </svg>
        </button>
      </div>
    </div>
    <!-- Scripts-->
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/lib/wow/wow.min.js"></script>
    <script src="assets/lib/easing/easing.min.js"></script>
    <script src="assets/lib/waypoints/waypoints.min.js"></script>
    <script src="assets/lib/counterup/counterup.min.js"></script>
    <script src="assets/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="assets/js/script-login.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/natural@6.5.0/lib/natural/index.min.js"></script>
    <script>
      $(function() {
        var Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });

        @error('gagallogin')
        $(function() {
          Toast.fire({
            icon: 'error',
            title: '{{ $message }}'
          })
        });
        @enderror
        @if(session('berhasilregister'))
        $(function() {
          Toast.fire({
            icon: 'success',
            title: '{{ session("berhasilregister") }}'
          })
        });
        @endif
      });
    </script>
    <script>
      $(document).ready(function() {
        $.validator.addMethod("ssoemail", function(value, element) {
          return this.optional(element) || /^[\w-\.]+@(student|staff|mipa)\.uns\.ac\.id|@mail\.com$/i.test(value);
        }, "Harus menggunakan email SSO");
        $.validator.addMethod("studentemail", function(value, element) {
          return this.optional(element) || /^[\w-\.]+@student\.uns\.ac\.id$/i.test(value);
        }, "Harus menggunakan email SSO");

        $('#loginform').validate({
          rules: {
            email: {
              required: true,
              email: true,
              ssoemail: true
            },
            password: {
              required: true,
              minlength: 8,
              maxlength: 255
            },
          },
          messages: {
            email: {
              required: "<strong>Email tidak boleh kosong</strong>",
              email: "<strong>Email tidak valid</strong>",
              ssoemail: "<strong>Email harus menggunakan email SSO</strong>",
            },
            password: {
              required: "<strong>Password tidak boleh kosong</strong>",
              minlength: "<strong>Password minimal 8 karakter</strong>",
              maxlength: "<strong>Password maksimal 255 karakter</strong>",
            },
          },
          errorClass: "invalid-feedback",
          errorElement: "span",
          highlight: function(element) {
            $(element).addClass('is-invalid');
          },
          unhighlight: function(element) {
            $(element).removeClass('is-invalid');
          },
        });
        $('#registerform').validate({
          rules: {
            nama: {
              required: true,
            },
            emailr: {
              required: true,
              email: true,
              studentemail: true
            },
            nim: {
              required: true,
            },
            no_telp: {
              required: true,
              digits: true,
            },
            passwordr: {
              required: true,
              minlength: 8,
              maxlength: 255
            },
            password_confirmation: {
              required: true,
              minlength: 8,
              maxlength: 255,
              equalTo: "#passwordr"
            },
            krs: {
              required: true,
            },
            transkrip: {
              required: true,
            },
            bukti_seminar: {
              required: true,
            },
          },
          messages: {
            nama: {
              required: "<strong>Nama tidak boleh kosong</strong>",
            },
            emailr: {
              required: "<strong>Email tidak boleh kosong</strong>",
              email: "<strong>Email tidak valid</strong>",
              ssoemail: "<strong>Email harus menggunakan email SSO</strong>",
            },
            nim: {
              required: "<strong>NIM tidak boleh kosong</strong>",
            },
            no_telp: {
              required: "<strong>No. Telp tidak boleh kosong</strong>",
              digits: "<strong>No. Telp harus berupa angka</strong>",
            },
            passwordr: {
              required: "<strong>Password tidak boleh kosong</strong>",
              minlength: "<strong>Password minimal 8 karakter</strong>",
              maxlength: "<strong>Password maksimal 255 karakter</strong>",
            },
            password_confirmation: {
              required: "<strong>Konfirmasi Password tidak boleh kosong</strong>",
              minlength: "<strong>Konfirmasi Password minimal 8 karakter</strong>",
              maxlength: "<strong>Konfirmasi Password maksimal 255 karakter</strong>",
              equalTo: "<strong>Konfirmasi Password tidak sama dengan Password</strong>",
            },
            krs: {
              required: "<strong>KRS tidak boleh kosong</strong>",
            },
            transkrip: {
              required: "<strong>Transkrip tidak boleh kosong</strong>",
            },
            bukti_seminar: {
              required: "<strong>Bukti Seminar tidak boleh kosong</strong>",
            },
          },
          errorClass: "invalid-feedback",
          errorElement: "span",
          highlight: function(element) {
            $(element).addClass('is-invalid');
          },
          unhighlight: function(element) {
            $(element).removeClass('is-invalid');
          },
        });
      });
    </script>
    @if( request()->get('register') == true )
    <script>$(function() {
      $('.form-panel.two').click();
    });
    </script>
    @endif
    <script>
      var running = false;
      function send() {
        if (running == true) return;
        var msg = $("#message").val();
        if (msg == "") return;
        running = true;
        addMsg(msg);
        loadMsg();
        $.ajax({
          url: "http://127.0.0.1/api/chatbot",
          type: "GET",
          data: {
            message: msg
          },
          success: function(response) {
            if (response.success == false) {
              switch(response.error) {
                case "input error":
                  addResponseMsg("Pesan tidak valid");
                  addResponseMsg(response.input);
                  break;
                case "Aku tidak mengerti":
                  addResponseMsg("Maaf saya tidak paham, tolong jelaskan lebih detail atau hubungi admin");
                  break;
                default:
                  addResponseMsg("Error: " + response.error);
                  break;
              };
              return;
            } else {
              switch(response.expression) {
                case "time greeting":
                    var hour = (new Date()).getHours();
                    if (hour >= 4 && hour < 12) {
                      addResponseMsg('Selamat pagi');
                    }
                    else if (hour >= 12 && hour < 15) {
                      addResponseMsg('Selamat siang');
                    }
                    else if (hour >= 15 && hour < 18) {
                      addResponseMsg('Selamat sore');
                    } else if (hour >= 18 && hour < 4) {
                      addResponseMsg('Selamat malam');
                    }
                  break;
                case 'greeting':
                  var random = Math.floor(Math.random() * response.response.length);
                  addResponseMsg(response.response[random]);
                  break;
                case "simple":
                  var random = Math.floor(Math.random() * response.response.length);
                  addResponseMsg(response.response[random]);
                  break;
                case "tech":
                  //addResponseMsg every response.response in order with delay 0.5s
                  var i = 0;
                  var interval = setInterval(function() {
                    addResponseMsg(response.response[i]);
                    i++;
                    if (i >= response.response.length) {
                      clearInterval(interval);
                    }
                  }, 500);
                  break;
              }
            }
          },
          error: function() {
            addResponseMsg("Error: Unable to connect to the server.");
          },
          complete: function() {
            running = false;
            removeLoadMsg();
          }
        });
      }

      function addMsg(msg) {
        var div = $("<div>").addClass("chat-message-div");
        div.html("<span style='flex-grow:1'></span><div class='chat-message-sent'>" + msg + "</div>");
        $("#message-box").append(div);
        $("#message").val("");
        $("#message-box").scrollTop($("#message-box")[0].scrollHeight);
      }

      function addResponseMsg(msg) {
        var div = $("<div>").addClass("chat-message-div");
        div.html("<div class='chat-message-received'>" + msg + "</div>");
        $("#message-box").append(div);
        $("#message-box").scrollTop($("#message-box")[0].scrollHeight);
        running = false;
      }
      function loadMsg()
      {
        var div = $("<div>").addClass("chat-message-div");
        div.html("<div class='chat-message-received' id='load' style='color:#b1b1b1'>Sedang mengetik...</div>");
        $("#message-box").append(div);
        $("#message-box").scrollTop($("#message-box")[0].scrollHeight);
      }

      function removeLoadMsg()
      {
        //remove #load
        $('#load').remove();
      }

      $("#message").keyup(function (event) {
        if (event.keyCode === 13) {
          event.preventDefault();
          send();
        }
      });

      $("#chatbot_toggle").click(function () {
        var chatbot = $("#chatbot");
        var chatbotToggle = $("#chatbot_toggle");

        if (chatbot.hasClass("collapsed")) {
          chatbot.removeClass("collapsed");
          chatbotToggle.children().eq(0).hide();
          chatbotToggle.children().eq(1).show();
          setTimeout(addResponseMsg, 1000, "Hi");
        } else {
          chatbot.addClass("collapsed");
          chatbotToggle.children().eq(0).show();
          chatbotToggle.children().eq(1).hide();
        }
      });
    </script>
  </body>
</html>