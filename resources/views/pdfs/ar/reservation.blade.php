<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reservation</title>
    <style>
    body {
      width: 59.5rem;
      font-family: Arial, sans-serif;
      font-size: 15px;
      margin: 0; /* Prevent default margins */
    }

    .reservation {
      width: 100%;
      position: relative;
    }

    h3 {
      margin-left: 1rem;
    }

    p {
     display: block;
      width: 40rem;
      margin-left: 2rem;
      margin-bottom: 1rem;
    }

     img{
        display: block;
        width: 100%;
        height:10rem;
        object-fit: contain;
     }
    strong {
        color:#1B9A9E;
    }
    </style>
</head>
<body>

    <div class="reservation" dir="rtl">
        <img src="{{ public_path('img/logo.png') }}" alt="logo">
        <div>
            <h3>معلومات العميل:</h3>
            <p>اسم العميل: <strong>{{ $reservationData['name'] }}</strong></p>
        </div>
        <div>
            <h3>معلومات الحجز:</h3>
            <p>قاعة الدرس: {{ $reservationData['classroom_name'] }}</p>
            <p>تاريخ البدء:<strong> {{ $reservationData['start_date'] }} </strong>- تاريخ الانتهاء: <strong>{{ $reservationData['end_date'] }}</strong></p>
        </div>
    </div>
</body>
</html>
