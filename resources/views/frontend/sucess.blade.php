<html>
  <head>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
  </head>
    <style>
      body {
        text-align: center;
        padding: 40px 0;
        background: #EBF0F5;
      }
        h1 {
          color: #88B04B;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-weight: 900;
          font-size: 40px;
          margin-bottom: 10px;
        }
        p {
          color: #404F5E;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-size:20px;
          margin: 0;
        }
      i {
        color: #9ABC66;
        font-size: 100px;
        line-height: 200px;
        margin-left:-15px;
      }
      .card {
        background: white;
        padding: 60px;
        border-radius: 4px;
        box-shadow: 0 2px 3px #C8D0D8;
        display: inline-block;
        margin: 0 auto;
      }
    </style>
    <body>
        <div class="card">
            <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
                <i class="checkmark">✓</i>
            </div>
            <h1>Success</h1> 
            <p>We received your purchase request;<br/> we'll be in touch shortly!</p>
            <p>Redirecting in <span id="countdown">3</span> seconds...</p>
        </div>
    
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script>
            let count = 3;
            let countdown = setInterval(function() {
                count--;
                $("#countdown").text(count);
                if (count <= 0) {
                  clearInterval(countdown);
                  @if (isset($returnData['user']) && $returnData['user'] != NULL)
                    @php
                      $userType = $returnData['user']->usertype ?? null;
                      $paymentType = $returnData['payment_type'] ?? null;
                    @endphp
                    @if ($paymentType === 'customer_order')
                      @if ($userType === 'customer')
                        window.location.href = "{{ route('customer.order.list') }}";
                      @elseif ($userType === 'seller' || $userType === 'vendor' || $userType === 'dropshipper')
                        window.location.href = "{{ route('seller.customer.order.list') }}";
                      @else
                        window.location.href = "{{ route('frontend.home') }}";
                      @endif
                    @elseif ($paymentType === 'user_subscription')
                      @if ($userType === 'seller' || $userType === 'vendor')
                        window.location.href = "{{ route('seller.dashboard') }}";
                      @elseif ($userType === 'dropshipper')
                        window.location.href = "{{ route('dropshipper.dashboard') }}";
                      @else
                        window.location.href = "{{ route('frontend.home') }}";
                      @endif
                    @else
                      window.location.href = "{{ route('frontend.home') }}";
                    @endif
                  @else
                    window.location.href = "{{ route('frontend.home') }}";
                  @endif
                }
            }, 1000);
        </script>
    </body>
    
    
</html>