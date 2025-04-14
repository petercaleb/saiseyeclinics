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
            text-align: center;
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

        .notes {
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Patient Prescription Receipt</h2>
            <p><strong>Patient ID:</strong> {{ $patient_id }}</p>
            <p><strong>Appointment ID:</strong> {{ $appointment_id }}</p>
            <p><strong>Schedule ID:</strong> {{ $schedule_id }}</p>
            <p><strong>Diagnosis ID:</strong> {{ $diagnoisis_id }}</p>
        </div>

        <div class="details">
            <h4>Prescription Details:</h4>
            <table>
                <thead>
                    <tr>
                        <th>Eye</th>
                        <th>Sphere</th>
                        <th>Cylinder</th>
                        <th>Axis</th>
                        <th>Additional Information</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Right</td>
                        <td>{{ $right_sphere }}</td>
                        <td>{{ $right_cylinder }}</td>
                        <td>{{ $right_axis }}</td>
                        <td>{{ $right_add }}</td>
                    </tr>
                    <tr>
                        <td>Left</td>
                        <td>{{ $left_sphere }}</td>
                        <td>{{ $left_cylinder }}</td>
                        <td>{{ $left_axis }}</td>
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
