@php
    use Illuminate\Support\Facades\DB;
    $hakAkses = auth()->check() ? (auth()->user()->hak_akses ?? []) : [];
    $hakAkses = is_array($hakAkses) ? $hakAkses : [];

    $menus = collect();
    if (!empty($hakAkses)) {
        $menus = DB::table('menu')
            ->whereIn('id', $hakAkses)
            ->where('status', 'aktif')
            ->orderBy('urutan')
            ->get();
    }

    $beranda = $menus->firstWhere('nama_menu', 'Beranda');
    $children = $menus->whereNotNull('parent_id')->groupBy('parent_id');

    $groupOrder = [
        'Pengaturan' => 'submenusettigs',
        'Master Data' => null,
        'Transaksi' => null,
        'Pelaporan' => null,
    ];
@endphp

<div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
    <ul class="navbar-nav">
        @if($beranda)
            <li class="nav-item">
                <a class="nav-link active bg-gradient-dark text-white" href="{{ url($beranda->route) }}">
                    <span class="material-symbols-rounded opacity-5">{{ $beranda->icon }}</span>
                    <span class="nav-link-text ms-1">{{ $beranda->nama_menu }}</span>
                </a>
            </li>
        @endif

        @foreach($groupOrder as $groupName => $fixedCollapseId)
            @php
                $items = $menus->where('group', $groupName);
            @endphp

            @if($items->isNotEmpty())
                <p class="text-uppercase text-muted ms-3 mb-1 mt-3" style="font-size: 12px;">
                    {{ $groupName }}
                </p>

                @foreach($items as $item)
                    @php
                        $itemChildren = $children->get($item->id, collect());
                        $isDropdown = $itemChildren->isNotEmpty();
                        $collapseId = $fixedCollapseId ?? ('submenu_' . $item->id);
                    @endphp

                    @if($isDropdown)
                        <li class="nav-item">
                            <a data-bs-toggle="collapse" href="#{{ $collapseId }}" class="nav-link text-dark py-2 my-1"
                                aria-controls="{{ $collapseId }}" role="button" aria-expanded="false">
                                @if($item->icon)
                                    <span class="material-symbols-rounded opacity-5">{{ $item->icon }}</span>
                                @endif
                                <span class="sidenav-normal ms-1">{{ $item->nama_menu }}</span>
                            </a>
                            <div class="collapse" id="{{ $collapseId }}">
                                <ul class="nav ms-4">
                                    @foreach($itemChildren as $child)
                                        <li class="nav-item">
                                            <a class="nav-link text-dark py-2" href="{{ url($child->route) }}">
                                                <span class="sidenav-normal">{{ $child->nama_menu }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link text-dark py-2 my-1" href="{{ url($item->route) }}">
                                @if($item->icon)
                                    <span class="material-symbols-rounded opacity-5">{{ $item->icon }}</span>
                                @endif
                                <span class="sidenav-normal ms-1">{{ $item->nama_menu }}</span>
                            </a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach
    </ul>
</div>