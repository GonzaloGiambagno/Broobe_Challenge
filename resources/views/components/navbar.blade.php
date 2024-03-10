<header class="header">
    <img src="{{  asset('images/logo.png') }}" alt="logo de la empresa broobe">


    <nav class="nav">
        <a href={{ route('run_metric') }}
            class="nav-links {{ Route::currentRouteName() === 'run_metric' ? 'active' : '' }}">Run
            Metric</a>
        <a href={{ route('history') }}
            class="nav-links {{ Route::currentRouteName() === 'history' ? 'active' : '' }}">Metric History</a>
    </nav>
</header>