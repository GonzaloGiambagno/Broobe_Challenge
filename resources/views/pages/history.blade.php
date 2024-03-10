<x-layout>
    <x-slot:title>History</x-slot>

        <section class="table_container">
                <table>
                    <thead>
                      <tr>
                        <th class="table_head" scope="col">URL</th>
                        <th class="table_head" scope="col">Accessibility</th>
                        <th class="table_head" scope="col">PWA</th>
                        <th class="table_head" scope="col">SEO</th>
                        <th class="table_head" scope="col">Performance</th>
                        <th class="table_head" scope="col">Best Practices</th>
                        <th class="table_head" scope="col">Strategy</th>
                        <th class="table_head" scope="col">Datetime</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($history as $metric)
                            <tr class="table-row">
                                <td class="table_value" data-label="URL"><a href="{{ $metric->url }}" targe="_blank">{{ $metric->url }}</a></td>
                                <td class="table_value" data-label="Accessibility">{{ $metric->accessibility_metric }}</td>
                                <td class="table_value" data-label="PWA">{{ $metric->pwa_metric }}</td>
                                <td class="table_value" data-label="SEO">{{ $metric->seo_metric }}</td>
                                <td class="table_value" data-label="Performance">{{ $metric->performance_metric }}</td>
                                <td class="table_value" data-label="Best Practices">{{ $metric->best_practices_metric }}</td>
                                <td class="table_value" data-label="Strategy">{{ $metric->strategy->name }}</td>
                                <td class="table_value" data-label="Datetime">{{ $metric->date }}</td>
                            </tr>
                        @empty
                        <tr><td>No hay metricas guardadas</td></tr>
                    @endforelse
        </section>
</x-layout>