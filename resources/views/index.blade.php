@component(config('cloud-sass.layout'))
    <div class="container">
        <h1>Welcome to Cloud SASS</h1>
        {{ dd(config('cloud-sass.migrations_location')) }}
        <p>Your one-stop solution for cloud-based SASS applications.</p>
    </div>
@endcomponent
