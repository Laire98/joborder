<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <link rel="stylesheet" href="css/bootstrap-login-form.min.css" />
  <link rel="stylesheet" href="css/styles.css" />
  <title>Job Order</title>
  </head>
</html>


<body>

  <section class="vh-100" style="background-image:url('/image/hardware-computer-repair-service.jpg'); background-repeat:no-repeat; background-size: 100% 100%;">
    <div class="container  py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card shadow-5-strong" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">
                <form id="formLogin" action="{{route('authenticate')}}" method="POST">
                    @csrf
                    <h3 class="mb-5">Sign in</h3>
                    <div class="form-outline mb-4">
                        <input type="email" id="login_email" name="email"  value="{{ old('email') }}" class="form-control form-control-lg" required/>
                        <label class="form-label">Email</label>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="password" id="login_password" name="password" value="{{ old('password') }}"  class="form-control form-control-lg" required/>
                        <label class="form-label">Password</label>
                    </div>
                    <div style="text-align:right">
                        @if($errors->any())
                        <ul style="color:darkred;">
                            @foreach($errors->all() as $error)
                            {{ $error }}
                            @endforeach
                        </ul>
                        @endif
                    </div>
                    <br>
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>

<script type="text/javascript" src="js/mdb.min.js"></script>


</html>
