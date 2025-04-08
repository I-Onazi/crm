@extends('layout.app')

@section('content')
<div class="container">
    <h2>Contacts</h2>
    <a href="{{ route('contacts.create') }}">Add Contact</a>
    <table border="1">
        <tr>
            <th>Name</th>
            
            <th>Phone Numbers</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        @foreach($contacts as $contact1)
        <tr>
            <td>{{ $contact1->name }}</td>
            {{-- <td>{{ $contact1->company }}</td> --}}
            <td>
                @foreach($contact1->phoneNumbers as $phone)
                    {{ $phone->phone_number }} <br>
                @endforeach
            </td>
            <td>
                @foreach($contact1->emails as $email)
                    {{ $email->email }} <br>
                @endforeach
            </td>
            <td>
                <a href="{{ route('contacts.edit', $contact1->id) }}">Edit</a> |
                <form action="{{ route('contacts.destroy', $contact1) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this contact?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
