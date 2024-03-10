<x-layout>
    <x-slot:title>Run Metric</x-slot>

        <form class='form-container' id="metricForm" method="POST" action="">
            @csrf
            <div class="form-url">
                <label class="ainput" for="url">URL:</label>
                <input class="input" type="text" name="url" id="url" placeholder="https://example@example.com/"
                    required>
            </div>

            <div class="form-categories">
                <label>Categories:</label>
                <div class="checkbox-container">
                    @foreach($categories as $category)
                    <div>
                        <input class="input" type="checkbox" name="categories" id="category"
                            value="{{ $category->name }}">
                        <label>{{ $category->name }}</label>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="form-footer">
                <div class="form-strategy">
                    <label for="strategy">Strategy:</label>
                    <select name="strategy" id="strategy" name="strategy" class="input input-strategy" required>
                        @foreach($strategies as $strategy)
                        <option value="{{ $strategy->name }}">{{ $strategy->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button class="button" type="button" onclick="runMetric()">Get Metric</button>
                </div>
            </div>

            <div id="loadingSpinnerContainer" class="hidden spin-container">
                <div class="spinner"></div>
                <p><i class="fa-solid fa-hourglass-half"></i>We are processing your request, it may take a few minutes. Please do not close or refresh the page</p>
            </div>

            <div id="metricResults" class="data-container">
            </div>
            <button id="saveMetricButton" class="hidden button btn-save" type="button" onclick="saveMetricRun()">
                Save Metric
            </button>
        </form>

        <script>
            var responselight;

            function runMetric() {
                    var url = document.getElementById("url").value;
                    var categories = Array.from(document.querySelectorAll('input[name="categories"]:checked')).map(function (category) {
                        return category.value;
                    });
                    var strategy = document.getElementById("strategy").value;
                    document.getElementById('loadingSpinnerContainer').classList.remove('hidden');

                    fetch('{{ route("get_metric") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json;charset=UTF-8',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            _token: "{{ csrf_token() }}",
                            url: url,
                            categories: categories,
                            strategy: strategy,
                        }),
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error("La api no responde");
                        }
                        return response.json();
                    })
                    .then(data => {
                        responselight = data.lighthouseResult;
                        console.log(responselight);
                        createCategoryCharts(responselight);
                        saveMetricButtonVisible();
                    })
                    .catch(error => {
                        console.error('Error al realizar la consulta:', error);
                    })
                    .finally(() => {
                        document.getElementById('loadingSpinnerContainer').classList.add('hidden');
                    });
            }

            function createCategoryCharts(lighthouseResult) {
                var chartContainer = document.getElementById("metricResults");
                    chartContainer.innerHTML = "";

                var categories = lighthouseResult.categories;
                    Object.keys(categories).forEach(function (categoryName) {
                        var category = categories[categoryName];
                        var chartDiv = document.createElement("div");
                        chartDiv.className = "category-chart";
                        var title = document.createElement("h3");
                        title.textContent = category.title;
                        chartDiv.appendChild(title);
                        var progressContainer = document.createElement("div");
                        progressContainer.className = "progress-container";
                        chartDiv.appendChild(progressContainer);

                        chartContainer.appendChild(chartDiv); 

                        var circleSize = category.score * 100;

                        var circle = new ProgressBar.Circle(progressContainer, {
                            color: '#79bddc',
                            strokeWidth: 5,
                            trailWidth: 1,
                            trailColor: '#eee',
                            svgStyle: null,
                            text: {
                                value: category.score,
                            },
                            duration: 1400,
                            easing: 'easeInOut',
                        });

                    circle.animate(category.score);

                    chartContainer.appendChild(chartDiv);
                });
            }

            function saveMetricButtonVisible() {
                let element = document.getElementById('saveMetricButton');
                if (element) {
                    element.classList.contains('hidden')
                    element.classList.remove('hidden');
                } else {
                    console.error('Error');
                }
            }

            function saveMetricRun() {
                var url = document.getElementById("url").value;
                var strategy = document.getElementById("strategy").value;

                const data = {
                    url: document.getElementById('url').value,
                    accessibility_metric: responselight.categories.accessibility ? responselight.categories.accessibility.score : null,
                    best_practices_metric: responselight.categories['best-practices'] ? responselight.categories['best-practices'].score : null,
                    performance_metric: responselight.categories.performance ? responselight.categories.performance.score : null,
                    pwa_metric: responselight.categories.pwa ? responselight.categories.pwa.score : null,
                    seo_metric: responselight.categories.seo ? responselight.categories.seo.score : null,
                    strategy_id: document.getElementById('strategy').value == 'DESKTOP' ? 1 : 2,
                }

                fetch('{{ route('store_metric') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    if (response.ok) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Successful save',
                            text: 'Metrics were saved successfully',
                            confirmButtonColor: "#75bfe2",
                        });
                    } else {
                        throw new Error('Error al guardar la métrica.');
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un error al guardar la métrica.'
                    });
                });
            }
        </script>
</x-layout>