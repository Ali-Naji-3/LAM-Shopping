@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4 text-dark">Website Settings</h2>

    {{-- @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif --}}

    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs" id="settingsTab" role="tablist">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#header">Header</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#hero">Hero</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#content">Content</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#footer">Footer</button></li>
        {{-- <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#other">Other</button></li> --}}
    </ul>

    <!-- Tabs Content -->
    <div class="tab-content p-4 border border-top-0 bg-light rounded-bottom" id="settingsTabContent">

        {{-- ================= HEADER ================= --}}
        <div class="tab-pane fade show active" id="header">
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="section" value="header">

                <h4 class="text-dark">Header Settings</h4>

                <!-- Logo -->
                <div class="mb-3">
                    <label class="form-label text-dark">Logo</label>
                    <input type="file" name="logo" class="form-control">
                    @if(!empty($setting->logo))
                        <img src="{{ asset('storage/'.$setting->logo) }}" class="mt-2" height="60">
                    @endif
                </div>

                <!-- Phone -->
                <div class="mb-3 mt-4">
                    <label class="form-label text-dark">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ $setting->phone ?? '' }}">
                </div>

                <!-- Name -->
                <div class="mb-3 mt-4">
                    <label class="form-label text-dark">Header Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $setting->name ?? 'Need Help?' }}">
                </div>

                <!-- Menu Items -->
                <h5 class="text-dark mt-4">Menu Items</h5>
                @php
                    $menuItems = !empty($setting->menu_items) ? json_decode($setting->menu_items, true) : [];

                @endphp

                <div id="menu-items-wrapper">
                    @if(!empty($menuItems))
                        @foreach($menuItems as $item)
                            <div class="menu-item mb-2">
                                <input type="text" name="menu_labels[]" placeholder="Label" class="form-control mb-1" value="{{ $item['label'] ?? '' }}">
                                <input type="text" name="menu_links[]" placeholder="URL" class="form-control" value="{{ $item['link'] ?? '' }}">
                            </div>
                        @endforeach
                    @else
                        <div class="menu-item mb-2">
                            <input type="text" name="menu_labels[]" placeholder="Label" class="form-control mb-1">
                            <input type="text" name="menu_links[]" placeholder="URL" class="form-control">
                        </div>
                    @endif
                </div>

                <button type="button" class="btn btn-secondary mt-2" id="add-menu-item">+ Add Menu Item</button>

                <script>
                    document.getElementById('add-menu-item').addEventListener('click', function(){
                        let wrapper = document.getElementById('menu-items-wrapper');
                        let div = document.createElement('div');
                        div.classList.add('menu-item', 'mb-2');
                        div.innerHTML = `
                            <input type="text" name="menu_labels[]" placeholder="Label" class="form-control mb-1">
                            <input type="text" name="menu_links[]" placeholder="URL" class="form-control">
                        `;
                        wrapper.appendChild(div);
                    });
                </script>

                <button type="submit" class="btn btn-primary mt-3">Save Header</button>
            </form>
        </div>

        {{-- ================= HERO ================= --}}
        <div class="tab-pane fade" id="hero">
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="section" value="hero">

                <h4 class="text-dark">Hero Section</h4>

                <!-- Background Video -->
                <div class="mb-3">
                    <label class="form-label text-dark">Background Video</label>
                    <input type="file" name="hero_background" class="form-control" accept="video/*">

                   @if(!empty($setting->hero_background))
    <video width="320" height="180" controls class="mt-2">
        <source src="{{ asset('storage/'.$setting->hero_background) }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
@endif


                </div>

                <!-- Title -->
                <div class="mb-3">
                    <label class="form-label text-dark">Title</label>
                    <input type="text" name="hero_title" class="form-control" value="{{ $setting->hero_title ?? '' }}">
                </div>

                <!-- Sub Title -->
                <div class="mb-3">
                    <label class="form-label text-dark">Sub Title</label>
                    <input type="text" name="hero_sub_title" class="form-control" value="{{ $setting->hero_sub_title ?? '' }}">
                </div>

                <!-- Button Text -->
                <div class="mb-3">
                    <label class="form-label text-dark">Button Text</label>
                    <input type="text" name="hero_button_text" class="form-control" value="{{ $setting->hero_button_text ?? '' }}">
                </div>

                <button type="submit" class="btn btn-primary">Save Hero</button>
            </form>
        </div>

        {{-- ================= CONTENT ================= --}}
        <div class="tab-pane fade" id="content">
           <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="section" value="content">

    <h4 class="text-dark">Content Section</h4>

    <div id="sliders-wrapper">
        @php
            $sliders = json_decode($setting->sliders ?? '[]', true);
        @endphp

        @foreach($sliders as $index => $slider)
        <div class="slider-item border p-3 mb-3 rounded text-dark">
            {{-- حقل رفع الصورة --}}
            <label class="text-dark">Image</label>
            <input type="file" name="sliders[{{ $index }}][image]" class="form-control mb-2">

            {{-- عرض الصورة الحالية إذا كانت موجودة --}}
            @if(!empty($slider['image']))
                <img src="{{ asset('storage/sliders/' . $slider['image']) }}" class="mt-2 mb-2" height="60">
            @endif

            {{-- حقل النص --}}
            <label class="text-dark">Text</label>
            <input type="text" name="sliders[{{ $index }}][text]" value="{{ $slider['text'] ?? '' }}" class="form-control mb-2">

            {{-- حقل الرابط --}}
            <label class="text-dark">Link</label>
            <input type="text" name="sliders[{{ $index }}][link]" value="{{ $slider['link'] ?? '' }}" class="form-control mb-2">

            {{-- زر إزالة --}}
            <button type="button" class="btn btn-danger btn-sm remove-slide">Remove</button>
        </div>
        @endforeach
    </div>

    {{-- زر إضافة slider جديد --}}
    <button type="button" class="btn btn-primary mb-3" id="add-slide">+ Add Slide</button>

    {{-- سكربت إضافة وحذف sliders ديناميكيًا --}}
    <script>
    document.getElementById('add-slide').addEventListener('click', function () {
        let wrapper = document.getElementById('sliders-wrapper');
        let index = wrapper.children.length;

        let slide = document.createElement('div');
        slide.classList.add('slider-item','border','p-3','mb-3','rounded','text-dark');
        slide.innerHTML = `
            <label class="text-dark">Image</label>
            <input type="file" name="sliders[${index}][image]" class="form-control mb-2">

            <label class="text-dark">Text</label>
            <input type="text" name="sliders[${index}][text]" class="form-control mb-2">

            <label class="text-dark">Link</label>
            <input type="text" name="sliders[${index}][link]" class="form-control mb-2">

            <button type="button" class="btn btn-danger btn-sm remove-slide">Remove</button>
        `;
        wrapper.appendChild(slide);
    });

    // حذف أي slider
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-slide')) {
            e.target.closest('.slider-item').remove();
        }
    });
    </script>

    <button type="submit" class="btn btn-success">Save Content</button>
</form>

        </div>

        {{-- ================= FOOTER ================= --}}
        <div class="tab-pane fade" id="footer">
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="section" value="footer">

        <h4 class="text-dark">Footer Settings</h4>


        <div class="mb-3">
            <label class="form-label text-dark">Footer Logo</label>
            <input type="file" name="footer_logo" class="form-control">
            @if(!empty($setting->footer_logo))
                <img src="{{ asset('storage/'.$setting->footer_logo) }}" class="mt-2" height="50">
            @endif
        </div>

{{-- Footer Links --}}
<div class="mb-3">
          @php
   $footer= !empty(  $setting->footer_links) ? json_decode(  $setting->footer_links, true) : [];

                @endphp
    <label class="form-label text-dark">Footer Links</label>
    <div id="footer-links">
        @if(!empty($footer))
            @foreach($footer as $index => $link)
                <div class="footer-link mb-2 d-flex gap-2">
                    <input type="text"
                           name="footer_links[{{ $index }}][title]"
                           value="{{ $link['title'] ?? '' }}"
                           class="form-control text-dark"
                           placeholder="Title">

                    <input type="text"
                           name="footer_links[{{ $index }}][url]"
                           value="{{ $link['url'] ?? '' }}"
                           class="form-control text-dark"
                           placeholder="URL">
                </div>
            @endforeach
        @else
            <div class="footer-link mb-2 d-flex gap-2">
                <input type="text" name="footer_links[0][title]" class="form-control text-dark" placeholder="Title">
                <input type="text" name="footer_links[0][url]" class="form-control text-dark" placeholder="URL">
            </div>
        @endif
    </div>
    <button type="button" onclick="addFooterLink()" class="btn btn-sm btn-primary mt-2">+ Add Link</button>
</div>

{{-- Footer Categories --}}
<div class="mb-3">

                @php
   $cat= !empty(  $setting->footer_categories) ? json_decode(  $setting->footer_categories, true) : [];

                @endphp
    <label class="form-label text-dark">Footer Categories</label>
    <div id="footer-categories">
        @if(!empty($cat))
            @foreach($cat as $index => $category)
                <div class="footer-category mb-2 d-flex gap-2">
                    <input type="text"
                           name="footer_categories[{{ $index }}][title]"
                           value="{{ $category['title'] ?? '' }}"
                           class="form-control text-dark"
                           placeholder="Category Title">

                    <input type="text"
                           name="footer_categories[{{ $index }}][url]"
                           value="{{ $category['url'] ?? '' }}"
                           class="form-control text-dark"
                           placeholder="Category URL">
                </div>
            @endforeach
        @else
            <div class="footer-category mb-2 d-flex gap-2">
                <input type="text" name="footer_categories[0][title]" class="form-control text-dark" placeholder="Category Title">
                <input type="text" name="footer_categories[0][url]" class="form-control text-dark" placeholder="Category URL">
            </div>
        @endif
    </div>
    <button type="button" onclick="addFooterCategory()" class="btn btn-sm btn-primary mt-2">+ Add Category</button>
</div>

{{-- Scripts --}}
<script>
    let linkIndex = {{ !empty($footer) ? count($footer) : 1 }};
    let categoryIndex = {{ !empty($footer_categories) ? count($footer_categories) : 1 }};

    function addFooterLink() {
        let container = document.getElementById('footer-links');
        let html = `
            <div class="footer-link mb-2 d-flex gap-2">
                <input type="text" name="footer_links[${linkIndex}][title]" class="form-control text-dark" placeholder="Title">
                <input type="text" name="footer_links[${linkIndex}][url]" class="form-control text-dark" placeholder="URL">
            </div>`;
        container.insertAdjacentHTML('beforeend', html);
        linkIndex++;
    }

    function addFooterCategory() {
        let container = document.getElementById('footer-categories');
        let html = `
            <div class="footer-category mb-2 d-flex gap-2">
                <input type="text" name="footer_categories[${categoryIndex}][title]" class="form-control text-dark" placeholder="Category Title">
                <input type="text" name="footer_categories[${categoryIndex}][url]" class="form-control text-dark" placeholder="Category URL">
            </div>`;
        container.insertAdjacentHTML('beforeend', html);
        categoryIndex++;
    }
</script>




        <div class="mb-3">
            <label class="form-label text-dark">Contact Name</label>
            <input type="text" name="contact_name" class="form-control" value="{{ $setting->contact_name ?? '' }}">
        </div>

        <div class="mb-3">
            <label class="form-label text-dark">Contact Phone</label>
            <input type="text" name="contact_phone" class="form-control" value="{{ $setting->contact_phone ?? '' }}">
        </div>

        <div class="mb-3">
            <label class="form-label text-dark">Contact Email</label>
            <input type="text" name="contact_email" class="form-control" value="{{ $setting->contact_email ?? '' }}">
        </div>

        <div class="mb-3">
            <label class="form-label text-dark">Contact Address</label>
            <input type="text" name="contact_address" class="form-control" value="{{ $setting->contact_address ?? '' }}">
        </div>

        <div class="mb-3">
            <label class="form-label text-dark">Copyright</label>
            <input type="text" name="footer_copyright" class="form-control" value="{{ $setting->footer_copyright ?? '' }}">
        </div>



        <button type="submit" class="btn btn-primary">Save Footer</button>
    </form>
</div>

{{--
        ================= OTHER =================
        <div class="tab-pane fade" id="other">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                <input type="hidden" name="section" value="other">

                <h4>Other Options</h4>
                <div class="mb-3">
                    <label class="form-label">Language</label>
                    <input type="text" name="language" class="form-control" value="{{ $setting->language ?? '' }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Currency</label>
                    <input type="text" name="currency" class="form-control" value="{{ $setting->currency ?? '' }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Payment Methods (JSON)</label>
                    <textarea name="payment_methods" class="form-control">{{ $setting->payment_methods ?? '' }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Save Other</button>
            </form>
        </div> --}}

    </div>
</div>
@endsection
