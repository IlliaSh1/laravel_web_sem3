@extends('/layout')
@section('content')
<h1>Contacts</h1>
<p>Name: {{ $contact['name'] }}</p>
<p>Address: {{ $contact['address'] }}</p>
<p>Phone: {{ $contact['phone'] }}</p>
@endsection