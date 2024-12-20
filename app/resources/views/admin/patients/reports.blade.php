<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
    <table style="width:100%;">
        <thead>
            <tr>
                <th>Full Names</th>
                <th>ID Number</th>
                <th>Telephone</th>
                <th>Email Address</th>
                <th>Date of Birth</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Next of Kin</th>
                <th>Next of Kin Contacts</th>
                <th>Added By</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($patients as $patient)
                <tr>
                    <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                    <td>{{ $patient->id_number }} </td>
                    <td>{{ $patient->phone }} </td>
                    <td>{{ $patient->email }} </td>
                    <td>{{ $patient->dob }} </td>
                    <td>{{ $patient->gender }} </td>
                    <td>{{ $patient->address }} </td>
                    <td>{{ $patient->next_of_kin }} </td>
                    <td>{{ $patient->next_of_kin_contact }} </td>
                    <td>{{ $patient->user->first_name }} {{ $patient->user->last_name }} </td>
                </tr>
            @empty
                <tr>
                    <td colspan="11">No Patient Data Found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
