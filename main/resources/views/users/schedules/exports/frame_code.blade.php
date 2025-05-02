<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Patient Frame code Receipt</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            padding: 30px;
            background-color: #fff;
            border: 1px solid #ccc;
        }

        .header {
            text-align: left;
            margin-bottom: 30px;
        }

        .header h2 {
            margin: 0;
            color: #333;
        }

        .details {
            margin-bottom: 30px;
        }

        .details p {
            margin: 5px 0;
        }

        .ref {
            font-size: 1.2rem;
            font-weight: 900;
        }

        address {
            font-style: normal;
            font-size: 12px;
            font-weight: lighter;
            line-height: 1.5;
            color: #666;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ccc;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-top: 30px;
        }

        table.info td {
            border: 0;
            border-bottom: 1px solid #ccc;
        }

        .notes {
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    @php
        $base = dirname(base_path()); // One level up from "main"
        $logoPath = $base . '/public/assets/logo.png';
        $logoPath = str_replace('\\', '/', $logoPath); // Ensure forward slashes for DOMPDF
        $logoData = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : null;
    @endphp
    <div class="container">
        <div class="header">
            <table style="width:100%;">
                <tr>
                    <td style="vertical-align: top; border: none">

                        @if ($logoData)
                            <img src="data:image/png;base64,{{ $logoData }}" alt="Radium Health Logo" height="60">
                        @else
                            <p style="color: red;">[Logo missing]</p>
                        @endif
                    </td>
                    <td style="vertical-align: top; border: none">
                        <h2 style="text-align: center">{{ $clinic_name }}</h2>
                        <address>
                            {{ $clinic_address }}, @php echo ucfirst(strtolower($clinic_location)) @endphp <br>
                            Tel: {{ $clinic_phone_number }} | Email: {{ $clinic_email }}
                        </address>
                    </td>
                </tr>
            </table>
        </div>



        <div class="details">
            <table class="info">
                <tr>
                    <td style="padding-left:0; padding-top:1rem"><strong>Name:</strong>
                        {{ $patient_name }} </td>
                    <td style="text-align:right; padding-top:1rem;">
                        <strong>Ref:</strong>
                        <span class="ref">{{ $receipt_no }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding-left:0; padding-top:1rem"><strong>Tel:</strong> {{ $patient_tel_no }} </td>
                    <td style="text-align:right; padding-top:1rem"><strong>Date:</strong> {{ $date }} </td>
                </tr>
            </table>

            <h3 style="margin-top:2rem; margin-bottom:1rem;">Frame Prescription</h3>
            <table>
                <tbody>
                    <tr>
                        <th>Frame code</th>
                        <th>Frame brand</th>
                    </tr>
                    <tr>
                        <td>{{ $frame_code }}</td>
                        <td>{{ $frame_brand }}</td>
                    </tr>

                    <tr>
                        <th>Case code</th>
                        <th>Case color</th>
                    </tr>
                    <tr>
                        <td>{{ $case_code }}</td>
                        <td>{{ $case_color }}</td>
                    </tr>
                    <tr>
                        <th>Case shape</th>
                        <th>Case size</th>
                    </tr>
                    <tr>
                        <td>{{ $case_shape }}</td>
                        <td>{{ $case_size }}</td>
                    </tr>

                </tbody>
            </table>
        </div>

        <div class="footer">
            <p>Thank you for choosing our services!</p>
        </div>
    </div>
</body>

</html>
