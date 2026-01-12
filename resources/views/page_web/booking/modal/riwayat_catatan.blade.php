@php
    $items = [];
    if ($booking->catatan && is_array($booking->catatan)) {
        $items = array_reverse($booking->catatan);
    }
@endphp

<div id="riwayatCatatanModal" class="custom-modal"
    style="display:none; position:fixed; inset:0; z-index:1060; align-items:center; justify-content:center; background: rgba(0,0,0,0.5);">
    <div class="custom-modal-content" role="dialog" aria-modal="true" aria-labelledby="riwayatCatatanTitle"
        style="background:#fff; width:min(680px, 92%); max-height:80vh; overflow:auto; border-radius:12px; box-shadow:0 10px 30px rgba(0,0,0,.2);">
        <div class="custom-modal-header"
            style="display:flex; align-items:center; justify-content:space-between; padding:16px 20px; border-bottom:1px solid #eee;">
            <h3 id="riwayatCatatanTitle"
                style="margin:0; font-size:18px; font-weight:700; display:flex; align-items:center; gap:8px;">
                <i class="fas fa-history"></i> Riwayat Catatan
            </h3>
            <button type="button" onclick="closeCatatanModal()" aria-label="Tutup"
                style="background:transparent; border:none; font-size:20px; cursor:pointer;">&times;</button>
        </div>

        <div class="custom-modal-body" style="padding:16px 20px;">
            @if (!empty($items))
                <div class="timeline" style="display:flex; flex-direction:column; gap:14px;">
                    @foreach ($items as $item)
                        <div class="timeline-item" style="display:flex; gap:12px;">
                            <div class="dot"
                                style="width:10px; height:10px; border-radius:50%; margin-top:6px; background:#ffc60a;">
                            </div>
                            <div class="content" style="flex:1;">
                                <div style="display:flex; align-items:center; gap:10px; margin-bottom:6px;">
                                    <span class="badge"
                                        style="display:inline-block; padding:4px 10px; border-radius:999px; background:#f7f7f7; font-size:12px;">
                                        {{ $item['status'] ?? '-' }}
                                    </span>
                                    <small class="text-muted" style="color:#666;">
                                        <i class="fas fa-calendar me-1"></i>{{ $item['tanggal'] ?? '' }}
                                        <i class="fas fa-clock ms-2 me-1"
                                            style="margin-left:8px;"></i>{{ $item['waktu'] ?? '' }}
                                    </small>
                                </div>
                                <div style="white-space:pre-wrap; line-height:1.6;">{{ $item['isi'] ?? '' }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted" style="text-align:center; margin:16px 0;">Belum ada catatan.</p>
            @endif
        </div>

        {{-- <div class="custom-modal-footer" style="padding:12px 20px; border-top:1px solid #eee; display:flex; justify-content:flex-end; gap:10px;">
            <button type="button" class="btn" onclick="closeCatatanModal()"
                    style="padding:8px 14px; border-radius:8px; border:1px solid #ddd; background:#fff; cursor:pointer;">Tutup</button>
        </div> --}}
    </div>
</div>

<script>
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('riwayatCatatanModal');
        if (!modal) return;
        if (e.target === modal) {
            closeCatatanModal();
        }
    });
</script>
