<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $clinic->clinic }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('users.dashboard.index') }}">Home</a>
                    </li>
                    @foreach (urlTree() as $item)
                        <li class="breadcrumb-item">
                            <a href="{{ $item['url'] }}">
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
