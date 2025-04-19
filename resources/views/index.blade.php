@component(config('cloud-sass::layouts-app'))
    @section('title', 'Cloud SASS')
    <div class="container">
        <h1>Welcome to Cloud SASS</h1>
        {{ dump(config('cloud-sass.migrations_location')) }}
        <p>Your one-stop solution for cloud-based SASS applications.</p>
    </div>
@endcomponent
