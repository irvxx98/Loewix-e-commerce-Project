<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        @if ($errors->any())
        <div class="alert alert-danger">
            <h6 class="fw-bold">Terjadi Kesalahan:</h6>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="row gx-5">
            <div class="col-lg-8">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Produk</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $product->name ?? '') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="12">{{ old('keterangan', $product->keterangan ?? '') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Gambar Produk</label>
                    <input type="file" name="images[]" class="form-control" multiple>
                    <small class="form-text text-muted">Anda bisa memilih lebih dari satu gambar. Gambar pertama akan menjadi thumbnail utama.</small>
                </div>
                @if(isset($product) && $product->images->isNotEmpty())
                <div class="mb-3">
                    <p class="form-label fw-semibold">Gambar Saat Ini:</p>
                    <div class="d-flex flex-wrap">
                        @foreach($product->images as $image)
                        <div class="me-3 mb-3 image-container image-container-admin-product">
                            <img src="{{ asset('storage/' . $image->image) }}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                            <form action="{{ route('admin.products.images.destroy', $image->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus gambar ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm delete-image-btn delete-image-btn-admin-product">&times;</button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            <div class="col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kategori</label>
                            <div id="category-selector-container"
                                data-categories='{{ json_encode($categoriesByParent) }}'
                                data-selected='{{ json_encode($selectedCategoryIds ?? []) }}'>
                            </div>
                            <input type="hidden" name="kategori_id" id="kategori_id" value="{{ old('kategori_id', $product->kategori_id ?? '') }}">
                        </div>
                        <div class="mb-3"><label class="form-label fw-semibold">Harga</label><input type="number" name="harga" class="form-control" value="{{ old('harga', $product->harga ?? '') }}" required></div>
                        <div class="mb-3"><label class="form-label fw-semibold">Diskon (%)</label><input type="number" name="diskon" class="form-control" value="{{ old('diskon', $product->diskon ?? '0') }}"></div>
                        <div class="mb-3"><label class="form-label fw-semibold">Berat (gram)</label><input type="number" name="berat" class="form-control" value="{{ old('berat', $product->berat ?? '') }}" required></div>
                        <div class="mb-3"><label class="form-label fw-semibold">Merk</label><input type="text" name="merk" class="form-control" value="{{ old('merk', $product->merk ?? 'Loewix') }}" required></div>
                        <div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" name="is_popular" value="1" id="is_popular" @checked(old('is_popular', $product->is_popular ?? false))><label class="form-check-label" for="is_popular">Jadikan Produk Populer</label></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-end bg-light py-3">
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan Produk</button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('category-selector-container');
        const categoriesByParent = JSON.parse(container.dataset.categories);
        const selectedCategoryIds = JSON.parse(container.dataset.selected);
        const finalCategoryInput = document.getElementById('kategori_id');

        function createSelector(parentId, selectedId = null) {
            const children = categoriesByParent[parentId] || [];
            if (children.length === 0) {
                const lastSelected = container.querySelector('select:last-of-type');
                if (lastSelected) {
                    finalCategoryInput.value = lastSelected.value;
                }
                return;
            }

            const select = document.createElement('select');
            select.className = 'form-select mb-2';
            select.innerHTML = '<option value="">Pilih...</option>';

            children.forEach(category => {
                const option = document.createElement('option');
                option.value = category.id;
                option.textContent = category.nama_kategori;
                if (category.id == selectedId) {
                    option.selected = true;
                }
                select.appendChild(option);
            });

            select.addEventListener('change', function() {
                const selectedValue = this.value;
                while (this.nextSibling) {
                    container.removeChild(this.nextSibling);
                }
                if (selectedValue) {
                    finalCategoryInput.value = selectedValue;
                    createSelector(selectedValue);
                } else {
                    const prevSelect = this.previousElementSibling;
                    finalCategoryInput.value = prevSelect ? prevSelect.value : '';
                }
            });
            container.appendChild(select);
        }

        function initializeSelectors() {
            let parentId = 0;
            selectedCategoryIds.forEach((id) => {
                createSelector(parentId, id);
                parentId = id;
            });

            const lastSelectedId = selectedCategoryIds[selectedCategoryIds.length - 1] || 0;
            if (categoriesByParent[lastSelectedId] && categoriesByParent[lastSelectedId].length > 0) {
                createSelector(lastSelectedId);
            }
        }

        if (selectedCategoryIds.length > 0) {
            initializeSelectors();
        } else {
            createSelector(0);
        }
    });
</script>