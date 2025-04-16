<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Patient Prescription Receipt</title>
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
                        <h2 style="text-align: center">Radium Health Services Ltd</h2>
                        <address>
                            Main Office: Enterprise Plaza, Adis Ababa Rd <br>
                            Industrial Area, Nairobi <br>
                            Tel: 0781666999 | Email: radiumhealthcare@gmail.com
                        </address>
                    </td>
                </tr>
            </table>
        </div>



        <div class="details">
            <table class="info">
                <tr>
                    <td><strong>Date:</strong> @php  echo date('d-m-Y')  @endphp</td>
                    <td style="text-align:right"><strong>Ref No:</strong> 475927525</td>
                </tr>
                <tr>
                    <td><strong>Name:</strong> Gladys Njuguna</td>
                    <td style="border-bottom: 0px"></td>
                </tr>
                <tr>
                    <td><strong>Tel:</strong> 0700223121</td>
                    <td style="border-bottom: 0px"></td>
                </tr>

            </table>
            <table>
                <thead>
                    <tr>
                        <th>Eye</th>
                        <th>Spherical</th>
                        <th>Cylindrical</th>
                        <th>Axis</th>
                        <th>Far</th>
                        <th>Near Addition</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Right</td>
                        <td>{{ $right_sphere }}</td>
                        <td>{{ $right_cylinder }}</td>
                        <td>{{ $right_axis }}</td>
                        <td>0001</td>
                        <td>{{ $right_add }}</td>
                    </tr>
                    <tr>
                        <td>Left</td>
                        <td>{{ $left_sphere }}</td>
                        <td>{{ $left_cylinder }}</td>
                        <td>{{ $left_axis }}</td>
                        <td>0001</td>
                        <td>{{ $left_add }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="notes">
            <p><strong>Notes:</strong> {{ $notes }}</p>
        </div>

        <div class="footer">
            <p>Thank you for choosing our services!</p>
        </div>
    </div>
</body>

</html>
