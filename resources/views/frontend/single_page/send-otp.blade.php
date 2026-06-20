@extends('frontend.layouts.master')

@section('custom_css')
<style>
  /* Main Container Styling */
#login {
    margin-top: 5%;
    margin-bottom: 5%;
}

/* Login Box Styling */
#login-box {
    background: #fff;
    padding: 30px;
    border-radius: 8px;0 cxs
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    max-width:600px; /* Ensures the box doesn't stretch too wide */
    margin-left: 33%;
}

/* Form Heading */
h3.text-center {
    margin-bottom: 25px;
    color: #17a2b8;
    font-weight: bold;
    text-align: center;
}

/* Form Labels */
.form-group label {
    font-weight: 600;
    color: #333;
}

/* Input Focus Effect */
.form-control:focus {
    border-color: #17a2b8;
    box-shadow: none;
}

/* Custom Button Styling */
.btn-custom {
    background-color: #17a2b8;
    color: #fff;
    font-weight: bold;
    border: none;
    padding: 10px;
}

.btn-custom:hover {
    background-color: #138496;
}

/* Additional Link (Signup) */
.additional-link {
    margin-top: 15px;
    font-size: 14px;
    color: #555;
    text-align: center;
}

.additional-link a {
    color: #17a2b8;
    font-weight: 600;
    text-decoration: none;
}

.additional-link a:hover {
    text-decoration: underline;
}

/* Alert Styling */
.alert {
    margin-top: 10px;
    margin-bottom: 20px;
    padding: 10px 15px;
    border-radius: 5px;
    font-size: 15px;
}

/* Responsive Adjustments */
@media (max-width: 767px) {
    #login-box {
        padding: 20px;
    }
    #login {
        margin-top: 15%;
    }
}
</style>
@endsection
@section('content')
  
<div class="container">
  <div class="row">
      <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
          @if (Session::get('success'))
              <div class="alert alert-success alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>{{ Session::get('success') }}</strong>
              </div>
          @endif
          <div id="login">
              <div id="login-box">
                  <form id="login-form" action="{{ route('send.customer.otp') }}" method="post">
                      @csrf
                      <h3 class="text-center">Email or Phone Number Verify</h3>

                      <div class="form-group">
                          <label for="context">Email or Phone Number:</label>
                          <input type="text" name="context" id="context" class="form-control" 
                          value="" >
                      </div>

                      
                      <div class="form-group">
                          <input type="submit"  class="btn btn-custom btn-block" value="Send Otp">
                      </div>

                    
                  </form>
              </div>
          </div>
      </div>
  </div>
</div>
  
    <script type="text/javascript">
        $(function() {
            $('#login-form').validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                    code: {
                        required: true
                    },
                },
                messages: {
                    email: {
                        required: "Please enter a email address",
                        email: "Please enter a vaild email address"
                    },
                    code: {
                        required: "Please enter your verification code"
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endsection
