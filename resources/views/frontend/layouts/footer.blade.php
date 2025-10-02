{{-- <footer class="revealed">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6">
					<h3 data-bs-target="#collapse_1">Quick Links</h3>
					<div class="collapse dont-collapse-sm links" id="collapse_1">
						<ul>
							<li><a href="{{ url('about-us.html') }}">About us</a></li>
							<li><a href="{{ url('help') }}">Faq</a></li>
							<li><a href="{{ url('help') }}">Help</a></li>
							<li><a href="{{ url('login') }}">My account</a></li>
							<li><a href="{{ url('blog.html') }}">Blog</a></li>
							<li><a href="{{ url('contacts.html') }}">Contacts</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<h3 data-bs-target="#collapse_2">Categories</h3>
					<div class="collapse dont-collapse-sm links" id="collapse_2">
						<ul>
							<li><a href="{{ url('listing-grid-1-full.html') }}">Clothes</a></li>
							<li><a href="{{ url('listing-grid-2-full.html') }}">Electronics</a></li>
							<li><a href="{{ url('listing-grid-1-full.html') }}">Furniture</a></li>
							<li><a href="{{ url('listing-grid-3.html') }}">Glasses</a></li>
							<li><a href="{{ url('listing-grid-1-full.html') }}">Shoes</a></li>
							<li><a href="{{ url('listing-grid-1-full.html') }}">Watches</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
						<h3 data-bs-target="#collapse_3">Contacts</h3>
					<div class="collapse dont-collapse-sm contacts" id="collapse_3">
						<ul>
							<li><i class="ti-home"></i>97845 Baker st. 567<br>Los Angeles - US</li>
							<li><i class="ti-headphone-alt"></i>+94 423-23-221</li>
							<li><i class="ti-email"></i><a href="#0">info@allaia.com</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
						<h3 data-bs-target="#collapse_4">Keep in touch</h3>
					<div class="collapse dont-collapse-sm" id="collapse_4">
						<div id="newsletter">
						    <div class="form-group">
						        <input type="email" name="email_newsletter" id="email_newsletter" class="form-control" placeholder="Your email">
						        <button type="submit" id="submit-newsletter"><i class="ti-angle-double-right"></i></button>
						    </div>
						</div>
						<div class="follow_us">
							<h5>Follow Us</h5>
							<ul>
								<li><a href="#0"><i class="bi bi-facebook"></i></a></li>
								<li><a href="#0"><i class="bi bi-twitter-x"></i></a></li>
								<li><a href="#0"><i class="bi bi-instagram"></i></a></li>
								<li><a href="#0"><i class="bi bi-tiktok"></i></a></li>
								<li><a href="#0"><i class="bi bi-whatsapp"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!-- /row-->
			<hr>
			<div class="row add_bottom_25">
				<div class="col-lg-6">
					<ul class="footer-selector clearfix">
						<li>
							<div class="styled-select lang-selector">
								<select>
									<option value="English" selected>English</option>
									<option value="French">French</option>
									<option value="Spanish">Spanish</option>
									<option value="Russian">Russian</option>
								</select>
							</div>
						</li>
						<li>
							<div class="styled-select currency-selector">
								<select>
									<option value="US Dollars" selected>US Dollars</option>
									<option value="Euro">Euro</option>
								</select>
							</div>
						</li>
						<li><img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="{{ asset('img/cards_all.svg') }}" alt="" width="198" height="30" class="lazy"></li>
					</ul>
				</div>
				<div class="col-lg-6">
					<ul class="additional_links">
						<li><a href="#0">Terms and conditions</a></li>
						<li><a href="#0">Privacy</a></li>
						<li><span>© 2024 Allaia</span></li>
					</ul>
				</div>
			</div>
		</div>
	</footer> --}}

@php
    use Illuminate\Support\Str;

    $setting = \App\Models\Setting::first();

    $decodeSafe = function ($value) {
        if (is_array($value)) {
            return $value;
        }

        if (empty($value)) {
            return [];
        }

        $s = trim($value);
        $decoded = @json_decode($s, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        if (Str::startsWith($s, '{') && Str::endsWith($s, '}')) {
            $s2 = '[' . $s . ']';
            $decoded = @json_decode($s2, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }
        }

        $attempt = str_replace("'", '"', $s);
        $decoded = @json_decode($attempt, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        $s3 = preg_replace('/[\r\n\t]+/', '', $s);
        $decoded = @json_decode($s3, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        $un = @unserialize($value);
        if ($un !== false && is_array($un)) {
            return $un;
        }

        return [];
    };

    $footer_links = $decodeSafe($setting->footer_links ?? '');
    $footer_categories = $decodeSafe($setting->footer_categories ?? '');
    $footer_socials = $decodeSafe($setting->footer_socials ?? '');
@endphp

<footer class="revealed">
    <div class="container">
        <div class="row">

            {{-- Quick Links --}}
            <div class="col-lg-3 col-md-6">
                <h3>Quick Links</h3>
                <div class="collapse dont-collapse-sm links">
                    <ul>
                        @if (!empty($footer_links) && is_array($footer_links))
                            @foreach ($footer_links as $link)
                                <li><a href="{{ url($link['url'] ?? '#') }}">{{ $link['title'] ?? 'No Name' }}</a></li>
                            @endforeach
                        @else
                            <li>No links added</li>
                        @endif
                    </ul>
                </div>
            </div>

            {{-- Categories --}}
            <div class="col-lg-3 col-md-6">
                <h3>Categories</h3>
                <div class="collapse dont-collapse-sm links">
                    <ul>
                        @if (!empty($footer_categories) && is_array($footer_categories))
                            @foreach ($footer_categories as $category)
                                <li><a
                                        href="{{ url($category['url'] ?? '#') }}">{{ $category['title'] ?? 'No Name' }}</a>
                                </li>
                            @endforeach
                        @else
                            <li>No categories added</li>
                        @endif
                    </ul>
                </div>
            </div>

            {{-- Contacts --}}
            <div class="col-lg-3 col-md-6">
                <h3>Contacts</h3>
                <div class="collapse dont-collapse-sm contacts">
                    <ul>
                        <li><i class="ti-home"></i>{{ $setting->contact_address ?? 'No address' }}</li>
                        <li><i class="ti-headphone-alt"></i>{{ $setting->contact_phone ?? 'No phone' }}</li>
                        <li><i class="ti-email"></i><a
                                href="mailto:{{ $setting->contact_email ?? '#' }}">{{ $setting->contact_email ?? 'No email' }}</a>
                        </li>

                    </ul>
                </div>
            </div>

            {{-- Newsletter & Socials --}}
            <div class="col-lg-3 col-md-6">
                <h3>Keep in touch</h3>
                <div class="collapse dont-collapse-sm">
                    <div id="newsletter" class="text-white">
                        <div class="form-group">
                            <input type="email" name="email_newsletter" id="email_newsletter"
                                class="form-control text-white" placeholder="Your email">
                            <button type="submit" id="submit-newsletter"><i class="ti-angle-double-right"></i></button>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row add_bottom_25">
                <div class="col-lg-6">
                    <ul class="footer-selector clearfix">

                        <li>
                            @if (!empty($setting->footer_logo))
                                <img src="{{ asset('storage/' . $setting->footer_logo) }}" alt="Footer Logo"
                                    width="198" height="30">
                            @endif
                        </li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <ul class="additional_links">

                        <li><span>©
                        <li>{{ $setting->footer_copyright ?? '#' }}</li> LAM</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
