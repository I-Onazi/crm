{{-- @extends('layout.app')

@section('content')
<div class="container">
    <h2>{{ isset($contact) ? 'Edit Contact' : 'Create Contact' }}</h2>

    <form action="{{ isset($contact) ? route('contacts.update', $contact->id) : route('contacts.store') }}" method="POST">
        @csrf
        @if(isset($contact))
            @method('PUT')
        @endif

        <div>
            <label>Name:</label>
            <input type="text" name="name" value="{{ isset($contact) ? $contact->name : '' }}" required>
        </div>
        
        <label>Phone Numbers</label>
        <div id="phone-numbers">
            @if(isset($contact) && $contact->phoneNumbers->count())
                @foreach($contact->phoneNumbers as $phone)
                    <input type="text" name="phone_numbers[]" value="{{ $phone->phone_number }}" placeholder="Phone Number">
                @endforeach
            @else
                <input type="text" name="phone_numbers[]" placeholder="Phone Number">
            @endif
        </div>
        <button type="button" onclick="addPhoneNumber()">Add Phone</button>

        <label>Emails</label>
        <div id="emails">
            @if(isset($contact) && $contact->emails->count())
                @foreach($contact->emails as $email)
                    <input type="email" name="emails[]" value="{{ $email->email }}" placeholder="Email">
                @endforeach
            @else
                <input type="email" name="emails[]" placeholder="Email">
            @endif
        </div>
        <button type="button" onclick="addEmail()">Add Email</button>

        <button type="submit" class="save">{{ isset($contact) ? 'Update' : 'Save' }}</button>
    </form>
</div>

<script>
    function addPhoneNumber() {
        let container = document.getElementById('phone-numbers');
        let input = document.createElement('input');
        input.type = 'text';
        input.name = 'phone_numbers[]';
        input.placeholder = 'Phone Number';
        container.appendChild(input);
    }

    function addEmail() {
        let container = document.getElementById('emails');
        let input = document.createElement('input');
        input.type = 'email';
        input.name = 'emails[]';
        input.placeholder = 'Email';
        container.appendChild(input);
    }
</script>
@endsection --}}



@extends('layout.app')

@section('content')
<div class="container">
    <h2>{{ isset($contact) ? 'Edit Contact' : 'Create Contact' }}</h2>
    
    <form action="{{ isset($contact) ? route('contacts.update', $contact->id) : route('contacts.store') }}" method="POST">
        @csrf
        @if(isset($contact))
            @method('PUT')
        @endif

        <div>
            <label>Name:</label>
            <input type="text" name="name" value="{{ $contact->name ?? '' }}" required>
        </div>

        {{-- <label>Phone Numbers</label>
        <div id="phone-numbers">
            @if(isset($contact))
                @foreach($contact->phoneNumbers as $phone)
                    <div class="phone-entry">
                        <input type="text" name="phone_numbers[]" value="{{ $phone->phone_number }}">
                        <button type="button" class="remove-btn" onclick="removeElement(this)">Remove</button>
                    </div>
                @endforeach
            @endif
            <div class="new-phone">
                <input type="text" name="phone_numbers[]" placeholder="Phone Number">
            </div>
        </div>
        <button type="button" onclick="addPhoneNumber()">Add Phone</button> --}}
        <label>Phone Numbers</label>
<div id="phone-numbers">
    @if(isset($contact) && $contact->phoneNumbers->count() > 0)
        @foreach($contact->phoneNumbers as $phone)
            <div class="phone-entry">
                <input type="text" name="phone_numbers[]" value="{{ $phone->phone_number }}">
                <button type="button" class="remove-btn" onclick="removeElement(this)">Remove</button>
            </div>
        @endforeach
    @else
        <input type="text" name="phone_numbers[]" placeholder="Phone Number">
    @endif
</div>
<button type="button" onclick="addPhoneNumber()">Add Phone</button>

        {{-- <label>Emails</label>
        <div id="emails">
            @if(isset($contact))
                @foreach($contact->emails as $email)
                    <div class="email-entry">
                        <input type="email" name="emails[]" value="{{ $email->email }}">
                        <button type="button" class="remove-btn" onclick="removeElement(this)">Remove</button>
                    </div>
                @endforeach
            @endif
            <div class="new-email">
                <input type="email" name="emails[]" placeholder="Email">
            </div>
        </div>
        <button type="button" onclick="addEmail()">Add Email</button> --}}
        <label>Emails</label>
<div id="emails">
    @if(isset($contact) && $contact->emails->count() > 0)
        @foreach($contact->emails as $email)
            <div class="email-entry">
                <input type="email" name="emails[]" value="{{ $email->email }}">
                <button type="button" class="remove-btn" onclick="removeElement(this)">Remove</button>
            </div>
        @endforeach
    @else
        <input type="email" name="emails[]" placeholder="Email">
    @endif
</div>
<button type="button" onclick="addEmail()">Add Email</button>


        <button type="submit" class="save">{{ isset($contact) ? 'Update' : 'Save' }}</button>
    </form>
</div>

<script>
    function addPhoneNumber() {
        let container = document.getElementById('phone-numbers');
        let div = document.createElement('div');
        div.classList.add('phone-entry');
        div.innerHTML = `
            <input type="text" name="phone_numbers[]" placeholder="Phone Number">
            <button type="button" class="remove-btn" onclick="removeElement(this)">Remove</button>
        `;
        container.appendChild(div);
    }

    function addEmail() {
        let container = document.getElementById('emails');
        let div = document.createElement('div');
        div.classList.add('email-entry');
        div.innerHTML = `
            <input type="email" name="emails[]" placeholder="Email">
            <button type="button" class="remove-btn" onclick="removeElement(this)">Remove</button>
        `;
        container.appendChild(div);
    }

    function removeElement(button) {
    let container = button.parentElement;
    container.remove();
}

</script>

@endsection
