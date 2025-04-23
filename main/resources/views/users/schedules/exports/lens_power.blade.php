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

        .ref {
            font-size: 1.5rem;
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
                    <td style="padding-left:0; padding-top:1rem"><strong>Name:</strong> {{ $patient_name }} </td>
                    <td style="text-align:right; padding-top:1rem;">
                        <strong>Ref:</strong>
                        <span class="ref">{{ $ref }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding-left:0; padding-top:1rem"><strong>Tel:</strong> {{ $patient_tel_no }} </td>
                    <td style="text-align:right; padding-top:1rem"><strong>Date:</strong> {{ $date }} </td>
                </tr>
            </table>

            <h3 style="margin-top:2rem; margin-bottom:1rem;">Lens power</h3>
            <table>
                <tbody>
                    <tr>
                        <td>
                            <h4>Left Eye</h4>
                            <table class="border-radius:0.375rem">
                                <tbody>
                                    <tr>
                                        <th>Sphere</th>
                                        <td>{{ $left_sphere }}</td>
                                    </tr>
                                    <tr>
                                        <th>Cylinder</th>
                                        <td>{{ $left_cylinder }}</td>
                                    </tr>
                                    <tr>
                                        <th>Axis</th>
                                        <td>{{ $left_axis }}</td>
                                    </tr>
                                    <tr>
                                        <th>Add</th>
                                        <td>{{ $left_add }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>

                        <td>
                            <h4>Right Eye</h4>
                            <table>
                                <tbody>
                                    <tr>
                                        <th>Sphere</th>
                                        <td>{{ $right_sphere }}</td>
                                    </tr>
                                    <tr>
                                        <th>Cylinder</th>
                                        <td>{{ $right_cylinder }}</td>
                                    </tr>
                                    <tr>
                                        <th>Axis</th>
                                        <td>{{ $right_axis }}</td>
                                    </tr>
                                    <tr>
                                        <th>Add</th>
                                        <td>{{ $right_add }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
            </table>

            <h3 style="margin-top:2rem; margin-bottom:1rem;">Lens prescription</h3>
            <table>
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Material</th>
                        <th>Index</th>
                        <th>Tint</th>
                        <th>Diameter</th>
                        <th>Focal Height</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $type }}</td>
                        <td>{{ $material }}</td>
                        <td>{{ $index }}</td>
                        <td>{{ $tint }}</td>
                        <td>{{ $diameter }}</td>
                        <td>{{ $focal_height }}</td>
                    </tr>
                </tbody>
            </table>
            <h3 style="margin-top:2rem;">Comments</h3>
            <table>
                <tbody>
                    <tr>
                        <td style="padding:1rem">@php  echo (!is_null($notes)) ? $notes : 'No comment' @endphp</td>
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
