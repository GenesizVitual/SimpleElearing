<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>PSB MTS Ummusshabri</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

      <link rel="stylesheet" href="{{ asset('asset_ppsb_login/css/style.css') }}">

  
</head>

<body>
  <div class="logmod">
  <div class="logmod__wrapper">
    <span class="logmod__close">Close</span>
    <div class="logmod__container">
      <ul class="logmod__tabs">
        <li data-tabtar="lgm-2"><a href="#">Login</a></li>
        <li data-tabtar="lgm-1"><a href="#">Registrasi</a></li>
      </ul>
      <div class="logmod__tab-wrapper">
      <div class="logmod__tab lgm-1">
        <div class="logmod__heading">
          <span class="logmod__heading-subtitle">Isilah Nama pengguna, Email, Password dibawah ini <strong>untuk membuat account</strong></span>
          @if(!empty(Session::get('message_success')))
            <span class="logmod__heading-subtitle" style="color: green">{{ Session::get('message_success') }}</span>
          @endif

          @if(!empty(Session::get('message_error')))
            <span class="logmod__heading-subtitle" style="color: red">{{ Session::get('message_error') }}</span>
          @endif
        </div>
        <div class="logmod__form">
          <form accept-charset="utf-8" action="{{ url('pendaftar') }}" method="post" class="simform">
            {{ csrf_field() }}
            <div class="sminputs">
              <div class="input full">
                <label class="string optional" for="user-name">Nama Pengguna*</label>
                <input class="string optional" maxlength="255" id="nama-pengguna" name="username" placeholder="Nama Pengguna" type="text"  required/>
              </div>
            </div>
            <div class="sminputs">
              <div class="input full">
                <label class="string optional" for="user-name">Email*</label>
                <input class="string optional" maxlength="255" id="user-email" name="email" placeholder="Email" type="email"  required/>
              </div>
            </div>
            <div class="sminputs">
              <div class="input string optional">
                <label class="string optional" for="user-pw">Password *</label>
                <input class="string optional" maxlength="255" id="user-pw" name="password" placeholder="Password" type="password" required/>
              </div>
              <div class="input string optional">
                <label class="string optional" for="user-pw-repeat">Isi ulang password *</label>
                <input class="string optional" maxlength="255" id="user-pw-repeat" name="repassword" placeholder="Isi ulang passowrd" type="password" />
              </div>
            </div>
            <div class="simform__actions">
              <button class="sumbit" type="sumbit" >Buat Akun</button>
              <span class="simform__actions-sidetext">By creating an account you agree to our <a class="special" href="#" target="_blank" role="link">Terms & Privacy</a></span>
            </div> 
          </form>
        </div> 

      </div>
      <div class="logmod__tab lgm-2">
        <div class="logmod__heading">
          <span class="logmod__heading-subtitle">Masukan email dan password anda <strong>untuk masuk ke sistem</strong></span>
          @if(!empty(Session::get('message_success')))
            <span class="logmod__heading-subtitle" style="color: green">{{ Session::get('message_success') }}</span>
          @endif

          @if(!empty(Session::get('message_error')))
            <span class="logmod__heading-subtitle" style="color: red">{{ Session::get('message_error') }}</span>
          @endif

          @if(count($errors) > 0)
            @foreach ($errors->all() as $error)
              <span class="logmod__heading-subtitle" style="color: orange">{{ $error }}</span>
            @endforeach
          @endif
        </div>
        <div class="logmod__form">
          <form accept-charset="utf-8" action="{{ url('login-pendaftar') }}" method="post" class="simform">
            {{ csrf_field() }}
            <div class="sminputs">
              <div class="input full">
                <label class="string optional" for="user-name">Email*</label>
                <input class="string optional" maxlength="255" id="user-email" name="email" placeholder="Email" type="email" size="50" />
              </div>
            </div>
            <div class="sminputs">
              <div class="input full">
                <label class="string optional" for="user-pw">Password *</label>
                <input class="string optional" maxlength="255" id="user-pw" name="password" placeholder="Password" type="password" size="50" />
                						<span class="hide-password">Show</span>
              </div>
            </div>
            <div class="simform__actions">
            <button class="sumbit"  type="sumbit" >Masuk</button>
              <span class="simform__actions-sidetext"><a class="special" role="link" href="#">Lupa Password<br>Klik disini</a></span>
            </div> 
          </form>
        </div> 

          </div>
      </div>
    </div>
  </div>
</div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script src="{{ asset('asset_ppsb_login/js/index.js') }}"></script>

</body>
</html>
