@extends('templates.dashboard')

@section('title', $property->summary)

@section('content')
    {{ $property->description }}

    <h4>Sellers</h4>
    @foreach ($property->sellers as $agent)
        <p>{{ $agent->full_name }} <a href="{{ route('property.delete_agent', [$property, $agent]) }}">[x]</a></p>
    @endforeach
    <input type="text" class="form-control" placeholder="Add Seller" id="Selling" />
    <h4>Viewers</h4>
    @foreach ($property->viewers as $agent)
        <p>{{ $agent->full_name }} <a href="{{ route('property.delete_agent', [$property, $agent]) }}">[x]</a></p>
    @endforeach
    <input type="text" class="form-control" placeholder="Add Viewer" id="Viewing" />

    <script>
        const onSelect = function (type, label, value) {
            if (!value) {
                console.log(arguments);
                return;
            }

            $.ajax({
                method: 'PUT',
                url: '{{ route('property.add_agent', $property) }}',
                data: {
                    type,
                    agent: value
                },
                success: function (data) {
                    document.location = location.href;
                },
                error: function (err) {
                    console.log(err);
                    alert(err.responseJSON.message);
                }
            })
        };

        $(function () {
            new Autocomplete(
                document.getElementById('Viewing'), {
                    maximumItems: 10,
                    threshold: 1,
                    data: {!! json_encode($agents) !!},
                    onSelectItem: ({label, value}) => onSelect('Viewing', label, value)
                }
            );

            new Autocomplete(
                document.getElementById('Selling'), {
                    maximumItems: 10,
                    threshold: 1,
                    data: {!! json_encode($agents) !!},
                    onSelectItem: ({label, value}) => onSelect('Selling', label, value)
                }
            );
        });
    </script>
@endsection
