@extends('template.master')
@section('title', __('All Movies'))
@section('main-content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Movies') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">
                        <a href="#">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Movies') }}</div>
                    <div class="breadcrumb-item">{{ __('All Movies') }}</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ __('All Movies') }}</h4>
                            </div>

                            <div class="card-body">

                                <div class="float-right">
                                    <form method="GET" action="{{ url('/') }}/movies" id="search-form">
                                        <div class="input-group">
                                            <input type="text" name="q" id="search-input" class="form-control"
                                                placeholder="{{ __('Search movies...') }}" value="{{ request('q') }}">

                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table table-striped" id="movie-table">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Poster') }}</th>
                                                <th>{{ __('Title') }}</th>
                                                <th>{{ __('Year') }}</th>
                                                <th>{{ __('Type') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody id="movie-container">
                                            @forelse ($movies as $data)
                                                <tr>

                                                    <td class="align-middle">
                                                        <img src="{{ $data['Poster'] }}" alt="{{ $data['Title'] }}"
                                                            class="rounded" width="50" height="70"
                                                            style="object-fit: cover">
                                                    </td>
                                                    <td class="align-middle">{{ $data['Title'] }}</td>
                                                    <td class="align-middle">{{ $data['Year'] }}</td>
                                                    <td class="align-middle">
                                                        <div class="badge badge-primary text-capitalize">
                                                            {{ $data['Type'] }}
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <a href="{{ route('movies.detail', ['imdbID' => $data['imdbID']]) }}?q={{ urlencode(request('q')) }}"
                                                            {{-- <a href="{{ route('movies.detail', ['imdbID' => $data['imdbID'], 'q' => request('q')]) }}" --}} class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye"></i>
                                                            {{ __('Detail') }}
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                @if (request('q'))
                                                    <tr id="empty-row">
                                                        <td colspan="5" class="text-center py-5">
                                                            <i class="fas fa-search fa-3x text-muted mb-3 d-block"></i>

                                                            <span class="text-muted">
                                                                {{ __('Movie not found!') }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr id="empty-row">
                                                        <td colspan="5" class="text-center py-5">
                                                            <i class="fas fa-search fa-3x text-muted mb-3 d-block"></i>

                                                            <span class="text-muted">
                                                                {{ __('Enter a keyword to search movies.') }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <div id="loader" class="text-center py-3" style="display: none;">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">{{ __('Loading...') }}</span>
                                    </div>

                                    <p class="text-muted mt-2">
                                        {{ __('Loading more movies...') }}
                                    </p>
                                </div>

                                <div id="no-more" class="text-center text-muted py-3" style="display: none;">
                                    <i class="fas fa-check-circle"></i>
                                    {{ __('All movies loaded.') }}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('scripts')
    <script>
        let page = 1;
        let isLoading = false;
        let hasMore = true;
        const query = "{{ request('q') }}";

        function loadMovies() {
            if (isLoading || !hasMore || !query) return;

            isLoading = true;
            page++;

            $('#loader').show();
            $('#no-more').hide();

            $.ajax({
                url: "{{ route('movies') }}",
                method: 'GET',
                data: {
                    q: query,
                    page: page
                },
                success: function(response) {
                    if (response.movies && response.movies.length > 0) {
                        response.movies.forEach(function(data) {
                            $('#movie-container').append(`
                            <tr>
                                <td class="align-middle">
                                    <img src="${data.Poster}" alt="${data.Title}"
                                        class="rounded" width="50" height="70"
                                        style="object-fit: cover">
                                </td>
                                <td class="align-middle">${data.Title}</td>
                                <td class="align-middle">${data.Year}</td>
                                <td class="align-middle">
                                    <div class="badge badge-primary text-capitalize">
                                        ${data.Type}
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <a href="/movies/${data.imdbID}?q=${encodeURIComponent(query)}"
                                        class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                        {{ __('Detail') }}
                                    </a>
                                </td>
                            </tr>
                        `);
                        });

                        const totalLoaded = page * 10;
                        if (totalLoaded >= response.total) {
                            hasMore = false;
                            $('#no-more').show();
                        }
                    } else {
                        hasMore = false;
                        $('#no-more').show();
                    }
                },
                error: function() {
                    page--;
                    hasMore = false;
                },
                complete: function() {
                    isLoading = false;
                    $('#loader').hide();
                }
            });
        }

        // Deteksi scroll mendekati bawah halaman
        $(window).on('scroll', function() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 200) {
                loadMovies();
            }
        });
    </script>
@endpush
